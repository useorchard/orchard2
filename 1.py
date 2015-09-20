#Orchard's Python script for initializing and eventually exiting the onboard Arduino serial port.

#Andrew McNeill, Orchard, September 20 2015

#-------------------------------

#Import libraries.

import serial
import os
import MySQLdb
import time
import sys

#-------------------------------

#Query the database and store value into check variable.

start = 0
stop = 1

print "Waiting for request to start serial port."

while start == 0:
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0") or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Start FROM Command")
  start = cursor.fetchone()[0]
  cursor.close()
  time.sleep(1)  

if start == 1:
  print "Request received. Initializing serial port now."
  #os.system('bash path_to_filename.sh')
  os.system('touch ~/Orchard/evan_coulstring.txt')
  time.sleep(5)
  sys.exit()
