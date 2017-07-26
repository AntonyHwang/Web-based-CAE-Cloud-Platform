@echo off

::job_id is the first parameter
set job_id=%1

(
echo ## PRE-PROCESSING  
echo sys gmsh %job_id%.geo
echo read gmsh.inp

echo # remove surface elements
echo zap +CPS6

echo send all abq
echo send support abq nam
echo comp load do
echo send load abq pres 1

echo plot f load
echo plus n support
echo hcpy png
echo sys ren hcpy_1.png sets.png

echo sys ccx solve

echo  ## POST-PROCESSING
echo read solve.frd

echo rot y
echo rot c 30
echo rot r 30
echo view disp
echo scal d 1000
echo view elem
echo ds -0 e 7
echo plot fv all
echo hcpy png
echo sys ren hcpy_2.png se.png
echo rot y
echo rot u 30
echo plot f all n
echo hcpy png
echo sys ren hcpy_3.png disp.png
echo quit
) > %job_id%.fbd