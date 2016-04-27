#!/usr/bin/env python
# get_airquality.py
# GrovePi Proxy for sensor.php using the Grove Air Quality Sensor (http://www.seeedstudio.com/wiki/Grove_-_Air_Quality_Sensor_v1.3)
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
print('script=' + os.path.basename(__file__) + '&port=' + str(analog_sensor_port)); 

try:
    # Get sensor value
    qual = grovepi.analogRead(analog_sensor_port);
except IOError:
    print('Error');
    sys.exit(12);

if qual > 700:
    rating = "High pollution";
elif qual > 300:
    rating = "Low pollution";
else:
    rating = "Air fresh";

outstring = 'quality=' + str(qual) + "&rating='" + rating + "'";
print(outstring);
sys.exit(0);
