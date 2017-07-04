from ftplib import FTP


def getFile():
    filename = input('What file do you want to get? ')
    localfile = open(filename, 'w+b')
    ftp.retrbinary('RETR ' + filename, localfile.write, 1024)  # write in 1024-byte chunks
    ftp.quit()
    print('In the file is: ')  # see what's in the file you got
    localfile.flush()
    localfile.seek(0)
    print(localfile.read().decode('ascii'))
    localfile.close()


def storeFile():
    filename = input('What file do you want to store? ')
    ftp.storbinary('STOR '+filename, open(filename, 'rb'))
    ftp.quit()
    print('Stored')


def main():
    print('Hello')
    ip = input("Enter a domain name or server IP address: ")
    global ftp
    ftp = FTP(ip)
    ftp.login(user='hello', passwd='hello')
    storeFile()
    # getFile()

if __name__ == '__main__':
    main()