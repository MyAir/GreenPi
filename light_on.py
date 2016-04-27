#!/usr/bin/env python
#
# Turn lights (D2) on
#
import grovepi

# Connect the Grove SPDT Relay to digital port D2
# SIG,NC,VCC,GND
relay = 2

grovepi.pinMode(relay,"OUTPUT")
# print "relais was ", grovepi.digitalRead(relay)
grovepi.digitalWrite(relay,1)
# print "relais is ", grovepi.digitalRead(relay)
