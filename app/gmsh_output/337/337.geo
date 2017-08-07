// Geometry.Tolerance=0.1; 
//Geometry.OCCFixSmallEdges=1; 
//Geometry.OCCFixSmallFaces=1; 
Merge "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\stp_uploads\337.step"; 
// Mesh control 
Mesh.ElementOrder=2; 
Mesh.Optimize=1; 
// Display control 
//Mesh.SurfaceEdges = 1; 
Mesh.SurfaceFaces = 1; 
Mesh.VolumeEdges = 0; 
//Mesh.VolumeFaces = 0; 
Mesh.CharacteristicLengthFactor = ; 
Mesh 3; 
Physical Volume("part") = {1}; 
Mesh.SaveGroupsOfNodes = 1; 
Save "gmsh.inp"; 
Exit; 
