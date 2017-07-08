import Adafruit_DHT
#import common
from config import C
import threading

class Measures:
    """Stores the values of temperature and humidity and gets the average"""

    _SENSOR = C.DHT_SENSOR()
    _PIN = C.DHT_PIN()
    _RETRIES = C.DHT_RETRIES()

    def __init__(self):
        self._count = 0
        self._temp = 0
        self._hum = 0
        self._lock = threading.RLock()
        
    def get_and_reset(self):
        """Return the average temperature and humidity and turns counter to 0"""
        with self._lock:
            count = self._count
            temp = self._temp
            hum = self._hum
            self._count = 0
            self._temp = 0
            self._hum = 0
            humidity = hum / count
            temperature = temp / count
        return humidity, temperature
    
    def add_measure(self):
        """Add one measure of temperature and humidity"""
        with self._lock:
            self._count = self._count + 1
            humidity, temperature = Adafruit_DHT.read_retry(Measures._SENSOR, Measures._PIN, retries=Measures._RETRIES)
            if humidity == None or temperature == None:
                self._log.warning('failed to read temperature/humidity')
            if humidity > 100: #Humidity can't be higer than 100%
                self._log.warning('Temp & humidity wrong value. Reading again')
            while humidity > 100: #Read new humidity data as the sensor failed
                humidity, temperature = Adafruit_DHT.read_retry(Measures._SENSOR, Measures._PIN, retries=Measures._RETRIES)
            self._hum = self._hum + humidity
            self._temp = self._temp + temperature
