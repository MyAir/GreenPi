#!/usr/bin/env python
#
# GrovePi Proxy for sensor.php using the Grove Moisture Sensor (http://www.seeedstudio.com/wiki/Grove_-_Moisture_sensor)
#
import sys
import os
import time
import grovepi

# Connect the Grove Moisture Sensor to analog port A0-A2
# SIG,NC,VCC,GND

# Read sensor port (0 - 2) from argument 1
analog_sensor_port = int(sys.argv[1]);

# Print the initial id String: script=<script>&port=<port>
print('script=' + os.path.basename(__file__) + '&' + 'port=' + str(analog_sensor_port)); 

try:
    moist = grovepi.analogRead(analog_sensor_port);		#Get the moisture value from analog_sensor_port
except IOError:
    print('Error')
    sys.exit(12);
    
# NOTE for wiki values <DryHumidWiki>:
# 	The wiki suggests the following analog_sensor_port values:
# 		Min  Typ  Max  Condition
# 		0    0    0    analog_sensor_port in open air
# 		0    20   300  analog_sensor_port in dry soil
# 		300  580  700  analog_sensor_port in humid soil
# 		700  940  950  analog_sensor_port in water
# 	Sensor values observer: 
# 		Val  Condition
# 		0    analog_sensor_port in open air
# 		18   analog_sensor_port in dry soil
# 		425  analog_sensor_port in humid soil
# 		690  analog_sensor_port in water
if(moist < 3):
    DryHumid = 'open';
elif(moist < 300):
    DryHumid = 'dry';
elif(moist < 700):
    DryHumid = 'humid';
else:
    DryHumid = 'water';

# construct string  "moist=999&DryHumid=<open/dry/humid/water>" 	
outstring = 'moist=' + str(moist) + "&DryHumid='" + DryHumid +"'";
print(outstring);
sys.exit(0);
