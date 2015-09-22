#Orchard's Python script for uploading serial load cell data to MySQl.

#Andrew McNeill, Orchard, September 20 2015

#-------------------------------

import serial
import os
import MySQLdb
import time
import sys

#-------------------------------

push = 0
stop = 0
message = 0

print "(Push) - Waiting for request to push logfile to database."

while push == 0:
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Push FROM Command")
  push = cursor.fetchone()[0]
  cursor.close()
  time.sleep(1)

while push == 1:
  if message == 0: 
    print "(Push) - Pushing logfile data to database."
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("TRUNCATE Weight")
  cursor.execute('LOAD DATA LOCAL INFILE "/home/orchard2/Orchard/weight.txt" INTO TABLE Weight')
  dbConn.commit()
  cursor.execute("SELECT Stop FROM Command")
  stop = cursor.fetchone()[0]
  cursor.close()
  message = 1
  if stop == 1:
    print "(Push) - Exiting push.py now."
    time.sleep(1)
    sys.exit()
  time.sleep(5)

#------------------------------
#-------------------------------
