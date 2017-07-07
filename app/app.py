## @file   app.py
#  @title   app     
#  @author  
#  @date    7/5/2017

from flask import Flask, render_template, request
import ftp
import database
import file_conversion

app = Flask(__name__)

##  @brief  routes get and post requests on /send
#           to the correct html page
#   @detail gets file to be opened from html and
#           calls storeFile to store it on ftp server
#   @return html templates to be rendered
@app.route('/send', methods=['GET', 'POST'])
def send():
    if request.method == 'POST':
        file = request.form['fileToUpload']
        job_id = database.writeToDB(file)
        #local copy of .stp in web server
        stp_file = open('%s.stp' % job_id, 'w')
        stp_file.write(file)
        file_conversion.stpTox3d(stp_file)
        stp_file.close()
        ftp.storeFile(file, job_id)
        return render_template('fileupload.html', file=file)
    return render_template('index.html')


if __name__ == "__main__":
    app.run()
