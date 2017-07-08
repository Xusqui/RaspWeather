import common
from config import C
from logger import LOGGER_FACTORY
#from vane_read import Vane
import spidev

spi=spidev.SpiDev()
spi.open(0,1)

def read_spi(channel):
		spidata=spi.xfer2([1,(8+channel)<<4,0])
		data=((spidata[1] & 3) << 8) + spidata[2]
		return data
	
def Veleta():
		voltaje=0
		while voltaje < 200: #<200 = error in reading.
			channeldata=read_spi(0)
			voltaje=round(((channeldata*3300)/1024),0)
		if (voltaje >= 2399.0 and voltaje < 2600.0):
			direccion = float(0.0) #N
		elif (voltaje >= 1118.0 and voltaje < 1398.0):
			direccion = float(22.5) #NNE
		elif (voltaje >= 1398.0 and voltaje < 1710.0):
			direccion = float(45) #NE
		elif (voltaje >= 241.20 and voltaje < 285.0):
			direccion = float(67.5) #ENE
		elif (voltaje >= 285.0 and voltaje < 365.0):
			direccion = float(90) #E
		elif (voltaje >= 200.0 and voltaje < 241.20):
			direccion = float(112.5) # ESE
		elif (voltaje >= 502.0 and voltaje < 692.0):
			direccion = float(135) #SE
		elif (voltaje >= 365.0 and voltaje < 502.0):
			direccion = float(157.5) #SSE
		elif (voltaje >= 585.0 and voltaje < 1118.0):
			direccion = float(180) #S
		elif (voltaje >= 692.0 and voltaje < 585.0):
			direccion = float(202.5) #SSW
		elif (voltaje >= 1982.0 and voltaje < 2148.0):
			direccion = float(225) #SW
		elif (voltaje >= 1710.0 and voltaje < 1982.0):
			direccion = float(247.5) #WSW
		elif (voltaje >= 2953.0):
			direccion = float(270) #W
		elif (voltaje >= 2600.0 and voltaje < 2764.0):
			direccion = float(292.5) #WNW
		elif (voltaje >= 2764.0 and voltaje < 2953.0):
			direccion = float(315) #NW
		elif (voltaje >= 2148.0 and voltaje < 2399.0):
			direccion = float(337.5) #NNW
		return direccion
		spi.close

class Direction:
    def __init__(self):
        self._log = LOGGER_FACTORY.get_logger('weather.vane')
        self._log.info('Vane Active')

    def get_sample(self):
        Wind_Direction = float(Veleta())
        if Wind_Direction == None:
            self._log.warning('failed to read Wind Vane')
        return 'vane', (common.timestamp(), float(Wind_Direction))
