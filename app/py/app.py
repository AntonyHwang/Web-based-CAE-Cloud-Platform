## @file    app.py
#  @title   app     
#  @author  
#  @date    7/5/2017

import sys
import file_conversion

job_id = sys.argv[1]
file_conversion.stpTox3d(job_id)
