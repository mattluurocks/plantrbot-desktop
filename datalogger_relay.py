#!/usr/bin/python

# Last edited on 2014/07/18 by Matt (matt@plantrbot.com
# This file is supposed to be called by a cronjob every X number of minutes
# and connects back to the plantrbot.com master db to allow users to remotely
# track their stats. This has the added code to run the relay that drives the pump.

import subprocess
import re
import sys
import time
import datetime
import RPi.GPIO as GPIO
import os
import MySQLdb
import smtplib
from configobj import ConfigObj
config = ConfigObj('/var/www/config.txt')

# ===========================================================================
# Email Account Details
# Need to work on moving this over to the website (2013/11/26 matt)
# ===========================================================================

# Account details for emailing notification

emailEnable = config['emailEnable']
emailServer = config['emailServer']
emailUser = config['emailUser']
emailPass = config['emailPass']

def sendemail(from_addr, 
	      to_addr_list, 
              subject, message,
              login, password,
              smtpserver=emailServer):
    header  = 'From: %s\n' % from_addr
    header += 'To: %s\n' % ','.join(to_addr_list)
    header += 'Subject: %s\n\n' % subject
    message = header + message
  
    server = smtplib.SMTP(smtpserver)
    server.starttls()
    server.login(login,password)
    problems = server.sendmail(from_addr, to_addr_list, message)
    server.quit()

# ===========================================================================
# Code for sensor data
# ===========================================================================

#START Getting light value
DEBUG = 1
GPIO.setmode(GPIO.BCM)

def Light (RCpin):
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
#END
# ===========================================================================
# Code for relay switch that controls pump
# ===========================================================================
#START

DEBUG = 1
GPIO.setmode(GPIO.BCM)

def Pump (RCpin):
        reading = 0
	GPIO.setwarnings(False)
        GPIO.setup(RCpin, GPIO.OUT)
        GPIO.output(RCpin, GPIO.HIGH)
	runTime = config['runTime']
        pumpTime = float(runTime)
	time.sleep(pumpTime)
	GPIO.output(RCpin, GPIO.LOW)
	reading += 1
	return reading
#END
# ===========================================================================
# Code for temp and humidity sensor
# ===========================================================================
#START

# Start loop that pulls DHT11 data
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

  print "Temperature: %.1f C" % temp
  print "Humidity:    %.1f %%" % humidity
 
  # get the light reading
  
  light = Light(24)
  print "Light: %.1f" % light

  # get pump reading

  pump = Pump(25)
  print "Pump Status: %.1f" % pump

#END
# ===========================================================================
# Code for inserting data into sql DBs       
# ===========================================================================
#START

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

#Insert data into REMOTE  mysql plantrbot db

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
  print "Wrote a row to remote DB"

#  emailEnable = config['emailEnable']
#  emailServer = config['emailServer']
#  emailUser = config['emailUser']
#  emailPass = config['emailPass']

  sendemail(from_addr    = emailUser,
          to_addr_list = [emailUser],
          subject      = 'PlantrBot Production Unit Checking In',
          message      = "Hello, just now the pump was run. The current temp is " + str(temp) + ", the humidity " + str(humidity) + ", and the light value of " + str(light) + ".",
          login        = emailUser,
          password     = emailPass)

  break
