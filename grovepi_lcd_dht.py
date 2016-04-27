# grovepi_lcd_dht.py

# dht(pin,module_type), change module_type number to use other kind of dht
# module_type:
#             DHT11 0
#             DHT22 1
#             DHT21 2
#             DHT2301 3

from grovepi import *
import grove_oled 
#from grove_oled import *

dht_sensor_port = 7		# Connect the DHt sensor to port 7
grove_oled.oled_init()
grove_oled.oled_clearDisplay()
grove_oled.oled_setNormalDisplay()
grove_oled.oled_setVerticalMode()
time.sleep(.1)

while True:
	try:
		[ temp,hum ] = dht(dht_sensor_port,1)		#Get the temperature and Humidity from the DHT sensor
		print "temp =", temp, "C\thumadity =", hum,"%" 	
		t = str(temp)
		h = str(hum)
		
		grove_oled.oled_setTextXY(0,0)
		grove_oled.oled_putString("Temp:" + t + "C")
		grove_oled.oled_setTextXY(1,0)
		grove_oled.oled_putString("Humi:" + h + "%")
	except (IOError,TypeError) as e:
		print "Error"