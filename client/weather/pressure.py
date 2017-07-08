import common
from config import C
from logger import LOGGER_FACTORY
from bmp183 import bmp183

class Pressure:
    """Reads BMP183 sensor for preasure / Temp """
    _CS = C.PRESSURE_CS()
    _SCK = C.PRESSURE_SCK()
    _SDI = C.PRESSURE_SDI()
    _SDO = C.PRESSURE_SDO()
    
    def __init__(self):
        self._log = LOGGER_FACTORY.get_logger('weather.pressure')
        self._log.info('CS=%d SCK=%d SDI=%d SDO=%d' % (Pressure._CS, Pressure._SCK, Pressure._SDI, Pressure._SDO))

    def get_sample(self):
        bmp = bmp183()
        bmp.measure_pressure()
        pre = bmp.pressure / 100.0
        if pre == None:
            self._log.warning('failed to read Pressure')
        return 'press', (common.timestamp(), pre)
