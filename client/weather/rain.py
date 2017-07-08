import RPi.GPIO as GPIO  #@UnresolvedImport

import common
from config import C
from logger import LOGGER_FACTORY
import rain_ticks

class Rain:
  """Provides Rain gauge measurement. Measurement will start immediately on creation."""

  def __init__(self):
    self._log = LOGGER_FACTORY.get_logger('weather.rain')
    self._ticks = rain_ticks.Ticks()
    # self._startup_time = common.timestamp()
    # TODO: Consider removing start timestamp and only use sample start/end timestamps.
    self._register_callback(self._ticks.add_edge)
    self._log.info('initialized')
    self._log.info('pin=%d debounce=%dms Wide=%g Long=%g Drops=%d' % (C.RAIN_INPUT_PIN(), C.RAIN_DEBOUNCE_MILLIS(), C.RAIN_SIZE_WIDE_MM(), C.RAIN_SIZE_LONG_MM(), C.RAIN_DROPS()))

  def _register_callback(self, callback):
    GPIO.setup(C.RAIN_INPUT_PIN(), GPIO.IN, pull_up_down=C.RAIN_PUD())
    GPIO.add_event_detect(C.RAIN_INPUT_PIN(), GPIO.RISING, callback=callback, bouncetime=C.RAIN_DEBOUNCE_MILLIS())

  def get_sample(self):
    ticks = self._ticks.get_and_reset()
    wide = C.RAIN_SIZE_WIDE_MM()
    long = C.RAIN_SIZE_LONG_MM()
    drops = C.RAIN_DROPS()
    area_mm2 = wide * long
    area_m2=area_mm2/1000000
    drops_m2 = drops / area_m2
    l_m2=drops_m2*0.001/20
    rain = ticks * l_m2
    return 'rain', (common.timestamp(), rain)
  
