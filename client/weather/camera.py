import common
from config import C
from picamera import PiCamera
from time import sleep
from logger import LOGGER_FACTORY

camera = PiCamera()

class Picture:
   """Takes Picture and stores it"""
   _RESOLUTION_HOR = C.CAMERA_RESOLUTION_HOR()
   _RESOLUTION_VER = C.CAMERA_RESOLUTION_VER()

   def __init__(self):
      self._log = LOGGER_FACTORY.get_logger('weather.camera')
      self._log.info('Resolution: Horizontal=%d Vertical=%d' % (Picture._RESOLUTION_HOR,Picture._RESOLUTION_VER))

   def get_sample(self):
      camera.resolution = (Picture._RESOLUTION_HOR, Picture._RESOLUTION_VER)
      camera.start_preview()
      sleep(2)
      timestamp = common.timestamp()
      camera.capture ('/var/www/html/pictures/picture%s.jpg' % timestamp)
      camera.stop_preview()
      return 'picture', timestamp
