## @file    app.py
#  @title   app     
#  @author  
#  @date    7/5/2017

from flask import Flask, render_template, request
import sys
import os
import ftp
import database
import file_conversion
import codecs

##  @brief  routes get and post requests on /send
#           to the correct html page
#   @detail gets file to be opened from html and
#           calls storeFile to store it on ftp server
#   @return html templates to be rendered
#@app.route('/send', methods=['GET', 'POST'])
# def send():
filename = sys.argv[1]
#job_id = str(database.writeToDB(filename))
os.rename('stp_uploads/' + filename, 'stp_uploads/%s.stp' % job_id)
#os.remove("tmp_uploads/" + filename)
#job_id = "temp"
#local copy of .stp in web server
#stp_file = open('stp_uploads/%s.stp' % job_id, 'r+')
#file_conversion.stpTox3d(stp_file, job_id)
file_conversion.stpTox3d(job_id)
ftp.storeFile( 'stp_uploads/%s.stp' % job_id)
ftp.storeFile( 'x3d_output/%s.x3d' % job_id)
#     return render_template('index.php')
#
# if __name__ == "__main__":
#     send()
