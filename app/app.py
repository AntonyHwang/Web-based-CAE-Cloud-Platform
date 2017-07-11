## @brief   app.oy
#  @title   app
#  @author
#  @date    7/5/2017

from flask import Flask, render_template, request, redirect, url_for, current_app
import ftp
import database
from werkzeug.utils import secure_filename
from shutil import copyfile
import io
from os.path import join
import os
import file_conversion

app = Flask(__name__)
UPLOAD_FOLDER = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'stp_uploads/')

app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
app.config['ALLOWED_EXTENSIONS'] = set(['STEP','stp', 'step'])
path = os.getcwd()


def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1] in app.config['ALLOWED_EXTENSIONS']

##  @brief  routes get and post requests on /send
#           to the correct html page
#   @detail gets file to be opened from html and
#           calls storeFile to store it on ftp server
#   @return html templates to be rendered

@app.route('/')
def index():
    return render_template('index.html', error="")


@app.route('/send', methods=['POST'])
def send():
    file = request.files['fileToUpload']

    if file and allowed_file(file.filename):

        filename = secure_filename(file.filename)

        file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))

        bio = io.BytesIO(file.read())

        job_id = database.writeToDB(filename)

        os.rename('stp_uploads/' + filename, 'stp_uploads/%s.stp' % job_id)

        file_conversion.stpTox3d(job_id)

        ftp.storeFile('stp_uploads/%s.stp' % job_id)
        ftp.storeFile('x3d_output/%s.x3d' % job_id)

        return render_template('fileupload.html', file=filename)

        #return redirect(url_for('viewer', filename = filename))

    return redirect(url_for('index', error="file upload invalid"))

#@app.route('/send/<filename>')
#def viewer(filename):
#    return render_template('fileupload.html', file=filename, displayFile=filename)

if __name__ == "__main__":
    app.run()