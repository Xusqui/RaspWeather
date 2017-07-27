import common
from config import C
from logger import LOGGER_FACTORY
import spidev

spi=spidev.SpiDev()
spi.open(0,1)

def read_spi(channel):
		spidata=spi.xfer2([1,(8+channel)<<4,0])
		data=((spidata[1] & 3) << 8) + spidata[2]
		return data
	
def Solar_Radiation():
        channeldata=read_spi(1)
        voltaje=channeldata*3300/1024
        Index = round((voltaje / 0.1),0)
		return Index
		spi.close

class Direction:
    def __init__(self):
        self._log = LOGGER_FACTORY.get_logger('weather.UVA')
        self._log.info('UVA Active')

    def get_sample(self):
        UV_Index = Solar_Radiation()
        if UV_Index == None:
            self._log.warning('failed to read Wind Vane')
        return 'radiation', (common.timestamp(), UV_Index)