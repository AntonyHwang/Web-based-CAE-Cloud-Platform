@echo off

set job_id=%1
set cls=%2
set clmax=%3
set clmin=%4

echo // Geometry.Tolerance=0.1; > "%job_id%.geo"
echo //Geometry.OCCFixSmallEdges=1; >> "%job_id%.geo"
echo //Geometry.OCCFixSmallFaces=1; >> "%job_id%.geo"
echo Merge "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\stp_uploads\%job_id%.step"; >> "%job_id%.geo"
echo // Mesh control >> "%job_id%.geo"
echo Mesh.ElementOrder=2; >> "%job_id%.geo"
echo Mesh.Optimize=1; >> "%job_id%.geo"
echo // Display control >> "%job_id%.geo"
echo //Mesh.SurfaceEdges = 1; >> "%job_id%.geo"
echo Mesh.SurfaceFaces = 1; >> "%job_id%.geo"
echo Mesh.VolumeEdges = 0; >> "%job_id%.geo"
echo //Mesh.VolumeFaces = 0; >> "%job_id%.geo"
echo Mesh.CharacteristicLengthFactor = %cls%; >> "%job_id%.geo"
echo Mesh.CharacteristicLengthMin = %clmin%; >> "%job_id%.geo"
echo Mesh.CharacteristicLengthMax = %clmax%; >> "%job_id%.geo"
echo Mesh 3; >> "%job_id%.geo"
echo Physical Volume("part") = {1}; >> "%job_id%.geo"
echo Mesh.SaveGroupsOfNodes = 1; >> "%job_id%.geo"
echo Save "gmsh.inp"; >> "%job_id%.geo"
echo Exit; >> "%job_id%.geo"
