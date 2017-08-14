@echo off

set job_id=%1
set cls=%2
set clmax=%3
set clmin=%4

mkdir gmsh_output\%job_id%

cd gmsh_output\%job_id%

call C:\www\ttt\scripts\check_msh\create_geo.bat %job_id% %cls% %clmax% %clmin%
call C:\www\ttt\scripts\check_msh\create_fbd.bat %job_id%

set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysis
cgx.bat -b %job_id%.fbd