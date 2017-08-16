## @file    app.py
#  @title   app     
#  @author  
#  @date    7/5/2017

import sys
import os
from os.path import dirname, abspath
import file_conversion

if __name__ == "__main__":
    job_id = sys.argv[1]
    file_conversion.stpTox3d(job_id)

