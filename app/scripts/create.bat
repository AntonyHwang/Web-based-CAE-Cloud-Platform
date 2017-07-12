@echo off

::job_id is the first parameter
set job_id = %1 

::support and load parameters for creating job_id.geo
set supp = %2
set load = %3

::run scripts that create job_id.fdb and job_id.geo
create_geo.bat %job_id% %supp% %load%

::path
::set absolute path of cgx
set path = %PATH%

::run analysis
cgx.exe -b %job_id%.fbd