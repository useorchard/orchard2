#Orchard's Python script for uploading serial load cell data to MySQl.

#Andrew McNeill, Orchard, August 24 2015

#-------------------------------

#Import libraries.

import MySQLdb
import time

#-------------------------------

#First, we establish a connection.

dbConn = MySQLdb.connect("localhost","orchard2","lobsterlobstercorn","orchard2",local_infile=1) or die ("Could not connect to database.")

#-------------------------------

#Next, we open a cursor to the database.

cursor = dbConn.cursor()

#-------------------------------

#Finally, we load the data file to our MySQL database.

cursor.execute('LOAD DATA LOCAL INFILE "/home/orchard2/Orchard/Data/data.txt" INTO TABLE weight') or die ("Could not upload file.")
dbConn.commit()

#------------------------------
#-------------------------------
