import base64
import bz2
import json
import threading
import time
import traceback
import urllib2

from args import ARGS
from config import C
import interceptor
from logger import LOGGER_FACTORY


class Uploader(threading.Thread):
  """Periodically uploads accumulated measurements."""

  def __init__(self, command_queue, termination_event):
    """Commands received from the server will be put into the command_queue."""
    threading.Thread.__init__(self)
    self._log = LOGGER_FACTORY.get_logger('weather.upload')
    self._main_cq = command_queue
    self._termination_event = termination_event
    self._queue = {}
    # To judge the quality of the uplink, the client transmits the number of failed upload attempts
    # in the metadata. Only counts connection errors, not server errors.
    self._failed_uploads = 0
    self._sources = []  # holds (data_source, buffering)
    # The uploader is itself a data source (number of failed attempts, and maybe more, some day).
    self.add_data_source(self, False)

  def add_data_source(self, data_source, buffering):
    """A data source provides a get_sample() method that returns a tuple of a key and a sample of
    arbitrary type (the server has to handle the sample type). The "buffering" flag controls
    handling of existing samples when polling a new sample (e.g. after an upload has failed): If
    True, the uploader maintains a list and new samples are appended, if False it stores only a
    single sample and overwrites it with the new sample (so that the type of sample appears at most
    once per upload)."""
    self._sources.append((data_source, buffering))

  def _poll_data_sources(self):
    for data_source, buffering in self._sources:
      type_key, sample = data_source.get_sample()
      if not sample:  # no data available
        continue
      if buffering:
        self._queue.setdefault(type_key, []).append(sample)
      else:  # overwrite
        self._queue[type_key] = sample

  def run(self):
    try:
      self._log.info('starting (upload interval: %ds)' % C.UPLOAD_INTERVAL_SECONDS())
      wait_seconds = C.UPLOAD_INTERVAL_SECONDS()
      while True:
        if self._termination_event.wait(wait_seconds):  # returns immediately if <= 0
          return
        start_time = time.time()
        self._poll_data_sources()
        client_command = interceptor.process(self._queue)
        server_commands = self._upload()
        commands = []
        if client_command:
          commands = [client_command]
        elif server_commands:
          commands = server_commands
        for command in commands:
          self._main_cq.put(command)
        wait_seconds = C.UPLOAD_INTERVAL_SECONDS() - (time.time() - start_time)
    except Exception:
      self._log.critical(traceback.format_exc())

  def get_sample(self):
    return 'upload', {'fails': self._failed_uploads}

  def _upload(self):
    """Returns True if data was uploaded, False if (likely) not."""
    data_json = json.dumps(self._queue)
    data_bz2 = bz2.compress(data_json)
    data_bz2_size = len(data_bz2)
    self._failed_uploads += 1  # assume failure; will reset to zero on success
    if data_bz2_size > C.UPLOAD_MAX_SIZE_KB() * 1024:
      self._queue = {}
      self._log.critical('discarded upload buffer of size %d after %d failed uploads' %
                         (data_bz2_size, self._failed_uploads))
      return

    try:
      request = urllib2.Request(ARGS.server_url() + 'ul.php', data_bz2,
          {'Content-Type': 'application/octet-stream'})
      if ARGS.server_username():
        user_colon_pass = '%s:%s' % (ARGS.server_username(), ARGS.server_password())
        auth_string = base64.encodestring(user_colon_pass).replace('\n', '')
        request.add_header('Authorization', 'Basic %s' % auth_string)
      self._log.debug('uploading %d bytes...' % data_bz2_size)
      response = urllib2.urlopen(request, timeout = C.TIMEOUT_HTTP_REQUEST_SECONDS())
      if response.getcode() != 200:
        self._log.error('failed to upload data: HTTP status code %d' % response.getcode())
        return
    except Exception:
      self._log.error('failed to upload data: %s' % traceback.format_exc())
      return
    response_content = response.read()
    try:
      response_dict = json.loads(response_content)
    except Exception:
      # This might be the 3G stick's error/"no network" (or rather: "no javascript" :-) page, to
      # which it redirects when offline.
      self._log.error(
          'failed to parse server response: %sserver response begins with: "%s"'
          % (traceback.format_exc(), response_content[:10240]))  # return first 10kB
      return
    if response_dict.setdefault('status', 'n/a') != 'ok':
      self._log.error('upload failed; status: %s' % response_dict['status'])
    else:
      self._log.debug('upload OK; response: %s' % response_content)
      self._log.debug('datos enviados: %s' % data_json)
      self._queue = {}
      self._failed_uploads = 0
    # Add commands to main command queue. This also happens on failure; an outdated client might be
    # causing the failure in the first place.
    del response_dict['status']
    server_commands = []
    for k, v in response_dict.items():
      server_commands.append((k, v))
    return server_commands
