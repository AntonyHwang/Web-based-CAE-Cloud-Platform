@echo off

::job_id is the first parameter
set job_id=%1

::support and load parameters for creating job_id.geo
set supp=%2
set load=%3

::create inp parameter
set youngs_mod = %4
set poissons = %5
set material = %6

::run scripts that create job_id.fdb, job_id.geo and solve.inp
call create_geo.bat %job_id% %supp% %load%
call create_fbd.bat %job_id%
call create_inp.bat %youngs_mod% %poissons% %material%

::path
::set absolute path of cgx
set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysisW
cgx.bat -b %job_id%.fbd