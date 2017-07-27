@echo off

::job_id is the first parameter
set job_id=%1

::support and load parameters for creating job_id.geo
set anchor_num=%2
set pressu_num=%3

::create inp parameter
set youngs_mod = %4
set poissons = %5
set material = %6

set anchors = ""
set pressures = ""
set count = 0
:getanchors
set anchors = %anchors%, %7;
shift

set count = %count%+1
if %count% = %anchor_num% (
    set count = 0
    goto getpressures
)
:getPressures
set pressures = %pressures%, %7;
shift

set count = %count%+1
if %count% = %pressu_num% (
    set count = 0
    goto endgets
)
:endgets


for /l %%x in (7, 1, %anchor_num%) do ()

::run scripts that create job_id.fdb, job_id.geo and solve.inp
call /scripts/create_geo.bat %job_id% %anchors% %pressures%
call /scripts/create_fbd.bat %job_id%
call /scripts/create_inp.bat %youngs_mod% %poissons% %material%

::path
::set absolute path of cgx
set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysisW
cgx.bat -b %job_id%.fbd