@echo off

set job_id=%1

cd C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\final_x3d
C:/mmh_ccx2vtk.exe "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\jobs\%job_id%\solve.frd"
call "C:/Program Files/ParaView 5.4.1/bin/pvpython.exe" "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\py\x3d_convert.py" %job_id%