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
import os
import time
import grovepi

# Connect the Grove SPDT Relay to digital port D4
# SIG,NC,VCC,GND
relay_port = int(sys.argv[1])

# Print the initial id String: script=<script>&port=<port>
print('script=' + os.path.basename(__file__) + '&port=' + str(relay_port)); 

try:
    # Get sensor value
    grovepi.pinMode(relay_port,"OUTPUT")
    relay_stat = grovepi.digitalRead(relay_port);
except IOError:
    print('Error');
    sys.exit(12);

outstring = 'state=' + str(relay_stat);
print(outstring);
sys.exit(0);
