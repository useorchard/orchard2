#Orchard's Python script for uploading serial load cell data to MySQl.

#Andrew McNeill, Orchard, September 20 2015

#-------------------------------

import serial
import os
import MySQLdb
import time
import sys

#-------------------------------

push = 1
stop = 1
message = 0

print "(Push) - Waiting a few seconds to push logfile to database."
time.sleep(4)

while push == 1:
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Push FROM Command")
  push = cursor.fetchone()[0]
  cursor.close()
  time.sleep(1)

while push == 2:
  if message == 0: 
    print "(Push) - Pushing logfile data to database."
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute('LOAD DATA LOCAL INFILE "/home/orchard2/Orchard/weight.txt" REPLACE INTO TABLE Weight')
  dbConn.commit()
  cursor.execute("SELECT Stop FROM Command")
  stop = cursor.fetchone()[0]
  cursor.close()
  message = 1
  if stop == 2:
    print "(Push) - Exiting push.py now."
    time.sleep(1)
    sys.exit()

#------------------------------
#-------------------------------
