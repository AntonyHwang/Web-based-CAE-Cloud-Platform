@echo off
::job_id is the first parameter
set job_id=%1

::support and load parameters
set supp=%2
set load=%3

::delete job_id.geo if exists
::if exist %job_id%.geo del %job_id%.geo

::set GMSH pre-processing script

echo // Geometry.Tolerance=0.1; > "%job_id%.geo"
echo //Geometry.OCCFixSmallEdges=1; >> "%job_id%.geo"
echo //Geometry.OCCFixSmallFaces=1; >> "%job_id%.geo"
echo Merge "part.step"; >> "%job_id%.geo"
echo // Mesh control >> "%job_id%.geo"
echo Mesh.ElementOrder=2; >> "%job_id%.geo"
echo Mesh.Optimize=1; >> "%job_id%.geo"
echo // Display control >> "%job_id%.geo"
echo //Mesh.SurfaceEdges = 1; >> "%job_id%.geo"
echo Mesh.SurfaceFaces = 1; >> "%job_id%.geo"
echo Mesh.VolumeEdges = 0; >> "%job_id%.geo"
echo //Mesh.VolumeFaces = 0; >> "%job_id%.geo"
echo Mesh 3; >> "%job_id%.geo"
echo Physical Surface("support") = {%supp%}; >> "%job_id%.geo"
echo Physical Surface("load") = {%load%}; >> "%job_id%.geo"
echo Physical Volume("part") = {1}; >> "%job_id%.geo"
echo Mesh.SaveGroupsOfNodes = 1; >> "%job_id%.geo"
echo Save "gmsh.inp"; >> "%job_id%.geo"
echo Exit; >> "%job_id%.geo"