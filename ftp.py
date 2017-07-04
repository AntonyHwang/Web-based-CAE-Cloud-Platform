from ftplib import FTP
import sys

def grabFile():
    filename = 'example.txt'
    localfile = open(filename, 'wb')
    ftp.retrbinary('RETR ' + filename, localfile.write, 1024)
    ftp.quit()
    localfile.close()

def placeFile():
    filename = 'exampleFile.txt'
    ftp.storbinary('STOR '+filename, open(filename, 'rb'))
    ftp.quit()

def main():
	print 'Hello'
	#domain name or server ip:
	ftp = FTP('127.0.0.1')
	ftp.login()
	# ftp.login(user='username', passwd = 'password')
	placeFile()
	grabFile()

if __name__ == '__main__':
	main()