##  @class: ftp.py
#   @authors:
#   @functions: getFile     recieves 1 specified file from ftp
#               storeFile   stores 1 specified file to ftp

import os
from ftplib import FTP

#predefined ftp credentials
_ip = "localhost"    #put ip address
_user = "local"      #put username
_passwd = "j"        #put password

##  @functionName:  getFile
#   @description:   looks into FTP given by the user for a file
#                   ftp credentials can be predefined above
#   @parameters:    filename   name of file to look for
#                   ip         ip address of ftp
#                   user       user account of ftp
#                   passwd     password of ftp user
def getFile(filename, ip = _ip, user = _user, passwd = _passwd):
    #connect to ftp
    ftp = FTP(ip, user, passwd)

    ###section for checking if file exists

    ###

    localfile = open(filename, 'w+b')
    ftp.retrbinary('RETR ' + os.path.basename(filename), localfile.write)
    ftp.quit()
    localfile.close()

##  @functionName:  storeFile
#   @description:   stores a file into FTP given by the user
#                   ftp credentials can be predefined above
#   @parameters:    filename   name of file to store into ftp
#                   ip         ip address of ftp
#                   user       user account of ftp
#                   passwd     password of ftp user
def storeFile(filename, ip = _ip, user = _user, passwd = _passwd):
    ftp = FTP(ip, user, passwd)
    ftp.storbinary('STOR '+ filename, open(filename, "rb"))
    ftp.quit()
    