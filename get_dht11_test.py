#!/usr/bin/env python
# get_dht11.py

# dht(pin,module_type), change module_type number to use other kind of dht
# module_type:
#             DHT11 0
#             DHT22 1
#             DHT21 2
#             DHT2301 3

import sys
from grovepi import *
import grove_oled 
#from grove_oled import *
print "get_dht11.py\n"
dht_sensor_port = int(sys.argv[1])		# Connect the DHt sensor to port 7
#print dht_sensor_port
#dht_sensor_port = 7
[ temp,hum ] = dht(dht_sensor_port,0)		#Get the temperature and Humidity from the DHT sensor
print "Humidity =", hum, "% Temperature =", temp, "*C \n" 	
