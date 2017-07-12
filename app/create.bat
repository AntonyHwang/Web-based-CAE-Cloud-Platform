@echo off

rem job_id
set job_id = %1 

rem run scripts that create job_id.fdb and job_id.geo

rem path
rem set absolute path of cgx
set path = %PATH%

rem run analysis
cgx.exe -b %job_id%.fbd