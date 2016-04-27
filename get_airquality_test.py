#!/usr/bin/env python
# get_airquality.py

import sys
# from grovepi import *
import time
import grovepi
import grove_oled 
#from grove_oled import *

print "get_airquality.py\n"

# Connect the Grove Air Quality Sensor to analog port A0
# SIG,NC,VCC,GND
# air_sensor = 0
air_sensor = int(sys.argv[1])		# Take first argument as pin

grovepi.pinMode(air_sensor,"INPUT")

while True:
    try:
        # Get sensor value
        sensor_value = grovepi.analogRead(air_sensor)

        if sensor_value > 700:
            print "High pollution"
        elif sensor_value > 300:
            print "Low pollution"
        else:
            print "Air fresh"

        print "sensor_value =", sensor_value
        time.sleep(.5)

    except IOError:
        print "Error"