## @file    app.py
#  @title   app     
#  @author  
#  @date    7/5/2017

import sys
import os
import database
import file_conversion

filename = sys.argv[1]
job_id = str(database.writeToDB(filename))
os.rename('stp_uploads/' + filename, 'stp_uploads/%s.stp' % job_id)
file_conversion.stpTox3d(job_id)
