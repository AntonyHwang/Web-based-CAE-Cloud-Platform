##  @file   ftp.py
#   @title  ftp
#   @author 
#   @date   7/5/2017

import os
from ftplib import FTP

#predefined ftp credentials
ip = "localhost"    #put ip address
user = "local"      #put username
passwd = "j"        #put password

##  @brief  getFile gets a file from FTP
#   @detail looks into FTP given by the user for a file
#           ftp credentials can be predefined above
#   @param  filename    name of file to look for
#   @param  ip          ip address of ftp
#   @param  user        user account of ftp
#   @param  passwd      password of ftp user
def getFile(filename):
    x3d_file = "%s.x3d" % filename
    png_file = "%s.png" % filename
    #connect to ftp
    ftp = FTP(ip, user, passwd)

    #download .x3d and .png files from ftp
    ftp.retrbinary('RETR %s' % x3d_file, open(x3d_file, 'wb').write)
    ftp.retrbinary('RETR %s' % png_file, open(png_file, 'wb').write)

    #localfile = open(filename, 'w+b')
    #ftp.retrbinary('RETR ' + os.path.basename(filename), localfile.write)
    #ftp.quit()
    #localfile.close()

##  @brief  storeFile saves a file in ftp
#   @detail stores a file into FTP given by the user
#           ftp credentials can be predefined above
#   @param  filename   name of file to store into ftp
#   @param  ip         ip address of ftp
#   @param  user       user account of ftp
#   @param  passwd     password of ftp user
def storeFile(file, job_id):
    ftp = FTP(ip, user, passwd)
    ftp.storbinary('STOR '+ str(job_id), open(file, "rb"))
    ftp.quit()
    