@echo off

set job_id=%1

cd C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\final_x3d
C:\mmh_ccx2vtk.exe "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\jobs\%job_id%\solve.frd"
python C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\py\vtk_stress.py %job_id%
::call "C:/Program Files/ParaView 5.4.1/bin/pvpython.exe" "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\py\x3d_convert.py" %job_id%
call "C:\ParaView 4.4.0\bin\pvpython.exe" "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\py\x3d_convert.py" %job_id%