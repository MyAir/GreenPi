#!/usr/bin/env python
#
# GrovePi Example for using the Grove SPDT Relay(30A) (http://www.seeedstudio.com/wiki/Grove_-_SPDT_Relay(30A))
#
# The GrovePi connects the Raspberry Pi and Grove sensors.  You can learn more about GrovePi here:  http://www.dexterindustries.com/GrovePi
#
# Have a question about this example?  Ask on the forums here:  http://www.dexterindustries.com/forum/?forum=grovepi
#

# NOTE:
# 	Relay is both normally open and normally closed.
# 	When the coil is energised, they will both flip.
# 	LED will illuminate when normally open is closed (and normally closed is open).

import sys
import time
import grovepi

# Connect the Grove SPDT Relay to digital port D4
# SIG,NC,VCC,GND
relay = int(sys.argv[1])
stat = int(sys.argv[2])

print "Setting pinMode of relay", relay, " to OUTPUT"
grovepi.pinMode(relay,"OUTPUT")
print "Getting Status of relay", relay
print grovepi.digitalRead(relay)
time.sleep(1)

print "Setting relay", relay, "to ", stat
grovepi.digitalWrite(relay,stat)
time.sleep(1)

print "Getting Status of relay", relay
print grovepi.digitalRead(relay)
time.sleep(1)
