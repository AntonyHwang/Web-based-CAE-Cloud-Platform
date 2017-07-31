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
    maxFaces = file_conversion.stpTox3d(job_id)
    # print(maxFaces)
    # #os.system('C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\scripts\\to_gmsh.bat stp_uploads\\{} gmsh_output\\{}'.format(job_id, job_id))
    # val =  dirname(dirname(abspath(__file__))) + "\\scripts"
    # os.system(val + '\\to_gmsh.bat stp_uploads\\{} gmsh_output\\{}'.format(job_id, job_id))

