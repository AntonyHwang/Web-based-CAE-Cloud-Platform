@echo off

::job_id is the first parameter
set job_id=%1

::support and load parameters for creating job_id.geo
set anchors=%2
set pressures=%3

::create inp parameter
set youngs_mod=%4
set poissons=%5
set material=%6

set cls=%7

echo %youngs_mod%

mkdir jobs\%job_id%

cd jobs\%job_id%

::run scripts that create job_id.fdb, job_id.geo and solve.inp
call C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create_geo.bat %job_id% %anchors% %pressures% %cls%
call C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create_fbd.bat %job_id%
call C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create_inp.bat %youngs_mod% %poissons% %material% %job_id%

::path
::set absolute path of cgx
set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysisW
call cgx.bat -b %job_id%.fbd

"C:\Program Files\PHP\v7.1\php.exe" C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\set_finished.php %job_id%



