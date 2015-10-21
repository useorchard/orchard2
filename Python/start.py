#Orchard's Python script for initializing and eventually exiting the onboard Arduino serial port.

#Andrew McNeill, Orchard, September 20 2015

#-------------------------------

import serial
import os
import MySQLdb
import time
import sys

#-------------------------------

start = 1
stop = 1
light = 1

print "(Start) - Waiting for request to start serial port."

while start == 1:
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0") or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Start FROM Command")
  start = cursor.fetchone()[0]
  cursor.close()
  time.sleep(1)  

if start == 2:
  print "(Start) - Request received. Initializing script to start serial port now."
  os.system('python /home/orchard2/Orchard/Python/retrieve.py')
  print "lobster"
 
  print "(Start) - Waiting for request to close serial port and reset USB connection."

  while stop == 1:
    dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0") or die ("Could not connect to database.")
    cursor = dbConn.cursor()
    cursor.execute("SELECT Stop FROM Command")
    stop = cursor.fetchone()[0]
    cursor.close()
    if stop == 2:
      print "(Start) - Stop requested from client. Closing serial port now."
      os.system('bash /home/orchard2/Orchard/Python/close_orchard1.sh')
      time.sleep(2)
      print "Goodbye."
      sys.exit()
    time.sleep(1)


#-------------------------------
#-------------------------------
