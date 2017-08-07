@echo off

set job_id=%1

set element_size=%2

mkdir gmsh_output\%job_id%

cd gmsh_output\%job_id%

call C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\check_msh\create_geo.bat %job_id% %cls%
call C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\check_msh\create_fbd.bat %job_id%

::path
::set absolute path of cgx
set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysis
cgx.bat -b %job_id%.fbd