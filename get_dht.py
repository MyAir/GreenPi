#!/usr/bin/env python
# get_dht11.py

# dht(pin,module_type), change module_type number to use other kind of dht
# module_type:
#             DHT11 0
#             DHT22 1
#             DHT21 2
#             DHT2301 3

import sys
import os
import time
from grovepi import *

# Read sensor port (6 - 8) from argument 1
digital_sensor_port = int(sys.argv[1]);		
# print digital_sensor_port

# D7 and D8 are used for DHT22, others can be DHT11
if digital_sensor_port == 7 or digital_sensor_port == 8:
    sensor_typ = 1;
else:
    sensor_typ = 0;
    
# Print the initial id String: script=<script>&port=<port>[&typ=<DHT sensor_typ(0,1)>]
print('script=' + os.path.basename(__file__) + '&' + 'port=' + str(digital_sensor_port) + '&' + 'typ=' + str(sensor_typ));

# Try to read values and output on success. Write "Error" on error.
try:
    #Get the temperature and Humidity from the DHT sensor
    [ temp,hum ] = dht(digital_sensor_port,sensor_typ);
except (IOError,TypeError) as e:
	print("Error")
	sys.exit(12);

# construct string  'temp=99.99&humid=99.99' 	
outstring = 'temp='; 
outstring += "{0:.2f}".format(temp); # Format the string placeholder "{0:.2f}" to float with input from (temp).
outstring += '&humid=';
outstring += '{0:.2f}'.format(hum);
print(outstring);
print(temp);
print(hum);
sys.exit(0);
