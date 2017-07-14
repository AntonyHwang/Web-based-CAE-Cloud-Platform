## @brief   app.oy
#  @title   app     
#  @author  
#  @date    7/5/2017

from flask import Flask, render_template, request, url_for, redirect, send_from_directory
from werkzeug import secure_filename
import ftp, os
#import database

app = Flask(__name__)

#Upload folder path
APP_ROOT = os.path.dirname(os.path.realpath(__file__))
UPLOAD_FOLDER = os.path.join(APP_ROOT, "uploads/")

#setting the upload folder
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
#setting the accepted extensions
app.config['ALLOWED_EXTENSIONS'] = set(['txt', 'pdf', 'png', 'jpg', 'jpeg', 'gif', 'STEP'])

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1] in app.config['ALLOWED_EXTENSIONS']

@app.route('/')
def index():
    return render_template('index.html')

##  @brief  routes get and post requests on /send
#           to the correct html page
#   @detail gets file to be opened from html and
#           calls storeFile to store it on ftp server
#   @return html templates to be rendered

@app.route('/upload', methods=['POST'])
def send():
    _file = request.files['fileToUpload']
    
    if _file and allowed_file(_file.filename):
        filename = secure_filename(_file.filename)

        _file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))

        #ftp.storeFile(_file)
        #database.writeToDB(file)
        return redirect(url_for('uploaded_file', filename=filename))

    return redirect(url_for('index'))

@app.route('/upload/_surface_clicks')
def surface_clicks():
    _file = send_from_directory(app.config['UPLOAD_FOLDER'], filename)



@app.route('/upload/<filename>')
def uploaded_file(filename):
    return render_template("fileupload.html")

if __name__ == "__main__":
    app.run()
