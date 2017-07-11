##  @file   ftp.py
#   @title  ftp
#   @author 
#   @date   7/5/2017

import os, sys
from ftplib import FTP

#predefined ftp credentials
_ip = "localhost"    #put ip address
_user = "local"      #put username
_passwd = "j"        #put password

##  @brief  getFile gets a file from FTP
#   @detail looks into FTP given by the user for a file
#           ftp credentials can be predefined above
#   @param  filename    name of file to look for
#   @param  ip          ip address of ftp
#   @param  user        user account of ftp
#   @param  passwd      password of ftp user
def getFile(filename, ip = _ip, user = _user, passwd = _passwd):
    #connect to ftp
    ftp = FTP(ip, user, passwd)

    ###section for checking if file exists
    if( not filename in ftp.nlst()):
        print "%s not exist" % filename
        sys.stdout.flush()
        ftp.quit()
        return 1
    ###

    localfile = open(filename, 'wb')
    ftp.retrbinary('RETR ' + os.path.basename(filename), localfile.write)
    ftp.quit()
    return 0

##  @brief  storeFile saves a file in ftp
#   @detail stores a file into FTP given by the user
#           ftp credentials can be predefined above
#   @param  filename   name of file to store into ftp
#   @param  ip         ip address of ftp
#   @param  user       user account of ftp
#   @param  passwd     password of ftp user
def storeFile(_file, ip = _ip, user = _user, passwd = _passwd):
    ftp = FTP(ip, user, passwd)
    ftp.storbinary('STOR '+ _file.filename, _file)
    ftp.quit()
    