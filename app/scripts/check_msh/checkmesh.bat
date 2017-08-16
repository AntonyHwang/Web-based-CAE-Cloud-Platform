@echo off

set job_id=%1
set cls=%2
set clmax=%3
set clmin=%4

if not exist gmsh_output\%job_id% (
	mkdir gmsh_output\%job_id%
)

cd gmsh_output\%job_id%

if exist "%job_id%.geo" (
	del %job_id%.geo
	del %job_id%.fbd
	del gmsh.inp
	del all.msh
) 

call C:\www\ttt\scripts\check_msh\create_geo.bat %job_id% %cls% %clmax% %clmin%
call C:\www\ttt\scripts\check_msh\create_fbd.bat %job_id%

set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysis
cgx.bat -b %job_id%.fbd