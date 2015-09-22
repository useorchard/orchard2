#Orchard's Python script for uploading serial load cell data to MySQl.

#Andrew McNeill, Orchard, August 24 2015

#-------------------------------

#Import libraries.

import serial
import MySQLdb
import time

#-------------------------------

#First, we establish a connection.

dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","orchard2") or die ("Could not connect to database.")

#-------------------------------

#Open a cursor to the database.

cursor = dbConn.cursor()

#-------------------------------

#Initialize serial port device.

device = '/dev/ttyUSB0'

try:
  print "Trying...",device 
  arduino = serial.Serial(device, 38400)
except: 
  print "Failed to connect on",device

#-------------------------------

#Wait five seconds to allow Arduino serial to "catch".

time.sleep(5)

#Read the data from the Arduino.

try:
  data = arduino.readline() 	#Read the data from the Arduino.
  pieces = data.split("\t\t")  	#Split the data by the tab.

  #Now insert data to our MySQL database.
  try:
    cursor.execute("INSERT INTO weight (gross,delta) VALUES (%s,%s)", (pieces[0],pieces[1]))
    dbConn.commit() 		#Commit the insert.
    cursor.close()  		#Close the cursor.
  except MySQLdb.IntegrityError:
    print "Failed to insert data."
  finally:
    cursor.close()  		#Close, in case the process failed.
except:
  print "Failed to get data from Arduino."

#-------------------------------
#-------------------------------
