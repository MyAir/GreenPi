#!/usr/bin/env python
# get_dht11.py

# dht(pin,module_type), change module_type number to use other kind of dht
# module_type:
#             DHT11 0
#             DHT22 1
#             DHT21 2
#             DHT2301 3

import sys
import time
from grovepi import *
import grove_oled 

# Read data from sensor
dht_sensor_port = int(sys.argv[1])		
#print dht_sensor_port
#dht_sensor_port = 7
[ temp,hum ] = dht(dht_sensor_port,0)		#Get the temperature and Humidity from the DHT sensor
# print "Humidity =", hum, "% Temperature =", temp, "*C \n" 	
outstring = 'temp=' + '{0:.2f}'.format(temp) + "&" + 'humid=' + '{0:.2f}'.format(hum);
print(outstring);
