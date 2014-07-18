#!/usr/bin/python

# Last edited on 2014/07/18 by Matt (matt@plantrbot.com
# This file is supposed to be called by a cronjob every X number of minutes
# and connects back to the plantrbot.com master db to allow users to remotely
# track their stats.

import subprocess
import re
import sys
import time
import datetime
import RPi.GPIO as GPIO
import os
import MySQLdb

# ===========================================================================
# Code for sensors
# ===========================================================================

# START code for pulling photocell data
DEBUG = 1
GPIO.setmode(GPIO.BCM)

def RCtime (RCpin):
        reading = 0
        GPIO.setup(RCpin, GPIO.OUT)
        GPIO.output(RCpin, GPIO.LOW)
	GPIO.setwarnings(False)
        time.sleep(0.1)
 
        GPIO.setup(RCpin, GPIO.IN)
        # This takes about 1 millisecond per loop cycle
        while (GPIO.input(RCpin) == GPIO.LOW):
                reading += 1
		if reading == 2000:
			reading = 0
                	break
        return reading
# END
# START code for pulling temp and humidity from DHT11

while(True):
  # Run the DHT program to get the humidity and temperature readings!

  output = subprocess.check_output(["/var/www/Adafruit_DHT", "11", "4"]);
  print output
  matches = re.search("Temp =\s+([0-9.]+)", output)
  if (not matches):
	time.sleep(3)
	continue
  temp = float(matches.group(1))
  
  # search for humidity printout
  matches = re.search("Hum =\s+([0-9.]+)", output)
  if (not matches):
	time.sleep(3)
	continue
  humidity = float(matches.group(1))

#END
#START print sensor data to console if run locally
  print "Temperature: %.1f C" % temp
  print "Humidity:    %.1f %%" % humidity

  # get the light reading
  
  light = RCtime(24)
  print "Light: %.1f" % light

  # fill in a 0 for the pump state
  # datalogger_relay.py actually runs and outputs pump
  # data. Here we just fill in the value with 0 for the
  # datapoint
  pump = 0

#END
#START uploading data to DBs

  #Insert data into local mysql local db

  # Open database connection
  db = MySQLdb.connect("","","","")

  # prepare a cursor object using cursor() method
  cursor = db.cursor()

  # Prepare SQL query to INSERT a record into the database.
  sql = """INSERT INTO DATA(CREATED_ON, TEMP,
         HUMIDITY, LIGHT, PUMPSTATE)
         VALUES (NOW(), '%s', '%s', '%s', '%s')""" % \
	(temp, humidity, light, pump)
  try:
   # Execute the SQL command
   cursor.execute(sql)
   # Commit your changes in the database
   db.commit()
  except:
   # Rollback in case there is any error
   db.rollback()

  # disconnect from server
  db.close()

  print "Wrote to the local DB"

  #Insert data into REMOTE mysql plantrbot db

  # Open database connection
  db = MySQLdb.connect("","","","")

  # prepare a cursor object using cursor() method
  cursor = db.cursor()

  # Prepare SQL query to INSERT a record into the database.
  sql = """INSERT INTO DATA(CREATED_ON, TEMP,
         HUMIDITY, LIGHT, PUMPSTATE)
         VALUES (NOW(), '%s', '%s', '%s', '%s')""" % \
        (temp, humidity, light, pump)
  try:
   # Execute the SQL command
   cursor.execute(sql)
   # Commit your changes in the database
   db.commit()
  except:
   # Rollback in case there is any error
   db.rollback()

  # disconnect from server
  db.close()

  # Wait 30 seconds before continuing
  print "Wrote a row to the remote DB"
#END
  break
