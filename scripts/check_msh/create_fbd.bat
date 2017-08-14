@echo off

set job_id=%1

(
echo ## PRE-PROCESSING  
echo sys gmsh %job_id%.geo
echo read gmsh.inp

echo # remove surface elements
echo zap +CPS6

echo send all abq
echo quit
) > %job_id%.fbd
