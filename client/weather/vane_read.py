import spidev

spi=spidev.SpiDev()
spi.open(0,1)
voltaje = 0

class Vane():
	def read_spi(channel):
		spidata=spi.xfer2([1,(8+channel)<<4,0])
		data=((spidata[1] & 3) << 8) + spidata[2]
		return data
	
	def calculate_direction(self):
		voltaje=0
		while voltaje < 200: #<200 = error in reading.
			channeldata=self.read_spi(0)
			voltaje=round(((channeldata*3300)/1024),0)
		if (voltaje >= 2399.0 and voltaje < 2600.0):
			direccion = 0 #N
		elif (voltaje >= 1118.0 and voltaje < 1398.0):
			direccion = 22.5 #NNE
		elif (voltaje >= 1398.0 and voltaje < 1710.0):
			direccion = 45 #NE
		elif (voltaje >= 241.20 and voltaje < 285.0):
			direccion = 67.5 #ENE
		elif (voltaje >= 285.0 and voltaje < 365.0):
			direccion = 90 #E
		elif (voltaje >= 200.0 and voltaje < 241.20):
			direccion = 112.5 # ESE
		elif (voltaje >= 502.0 and voltaje < 692.0):
			direccion = 135 #SE
		elif (voltaje >= 365.0 and voltaje < 502.0):
			direccion = 157.5 #SSE
		elif (voltaje >= 585.0 and voltaje < 1118.0):
			direccion = 180 #S
		elif (voltaje >= 692.0 and voltaje < 585.0):
			direccion = 202.5 #SSW
		elif (voltaje >= 1982.0 and voltaje < 2148.0):
			direccion = 225 #SW
		elif (voltaje >= 1710.0 and voltaje < 1982.0):
			direccion = 247.5 #WSW
		elif (voltaje >= 2953.0):
			direccion = 270 #W
		elif (voltaje >= 2600.0 and voltaje < 2764.0):
			direccion = 292.5 #WNW
		elif (voltaje >= 2764.0 and voltaje < 2953.0):
			direccion = 315 #NW
		elif (voltaje >= 2148.0 and voltaje < 2399.0):
			direccion = 337.5 #NNW
		return direccion
		spi.close
