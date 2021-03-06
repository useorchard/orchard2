#Orchard's Python script for retrieving load cell data from onboard Pi.

#Andrew McNeill, Orchard, September 20 2015

#-------------------------------

import serial
import os
import MySQLdb
import time
import sys

#-------------------------------

retrieve = 1
stop = 1
message = 0

os.system('bash /home/orchard2/Orchard/Python/start_orchard1.sh')
print "(Retrieve) - Serial port opened."
os.system('bash /home/orchard2/Orchard/Python/tmux_push.sh')
print "(Push) - Push loop to database initialized."
print "(Retrieve) - Waiting to retrieve serial logfile from onboard computer."

while retrieve == 1:
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Retrieve FROM Command")
  retrieve = cursor.fetchone()[0]
  cursor.close()
  time.sleep(1)

while retrieve == 2:
  if message == 0:
    print "(Retrieve) - Sending converted serial logfile from onboard computer to server."
  os.system('bash /home/orchard2/Orchard/Python/send_orchard1.sh')
  dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","Cart_0", local_infile = 1) or die ("Could not connect to database.")
  cursor = dbConn.cursor()
  cursor.execute("SELECT Stop FROM Command")
  stop = cursor.fetchone()[0]
  cursor.close()
  message = 1
  if stop == 2:
    print "(Retrieve) - Exiting retrieve.py now."
    os.system('bash /home/orchard2/Orchard/Python/kill_tmux_push.sh')
    time.sleep(1)
    sys.exit()
  time.sleep(1)
  
