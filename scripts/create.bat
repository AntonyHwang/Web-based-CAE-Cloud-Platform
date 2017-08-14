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
call C:\www\ttt\scripts\create_geo.bat %job_id% %anchors% %pressures% %cls%
call C:\www\ttt\scripts\create_fbd.bat %job_id%
call C:\www\ttt\scripts\create_inp.bat %youngs_mod% %poissons% %material% %job_id%

::path
::set absolute path of cgx
set path = "C:\Program Files (x86)\bConverged\CalculiX\bin";%PATH%

::run analysisW
call cgx.bat -b %job_id%.fbd

call echo. | C:\mmh_ccx2vtk.exe "C:\www\ttt\jobs\%job_id%\solve.frd"
python C:\www\ttt\py\vtk_stress.py %job_id%

call echo. | C:\www\ttt\scripts\create_x3d.bat %job_id% 1000

"C:\Program Files (x86)\PHP\v7.1\php.exe" C:\www\ttt\set_finished.php %job_id%



