from flask import Flask, render_template, request
from ftplib import FTP


app = Flask(__name__)


@app.route('/send', methods=['GET', 'POST'])
def send():
    if request.method == 'POST':
        file = request.form['fileToUpload']

        ip = "127.0.0.1"
        global ftp
        ftp = FTP(ip)
        ftp.login(user='temp', passwd='temp')

        storeFile(file)
        return render_template('fileupload.html', file=file)
    return render_template('index.html')

# can only store files in C:
# should update to include any filepath
def storeFile(file):
    ftp.storbinary('STOR '+file, open('C:\\' + file, 'rb'))
    ftp.quit()
    print('Stored')


if __name__ == "__main__":
    app.run()
