// Geometry.Tolerance=0.1; 
//Geometry.OCCFixSmallEdges=1; 
//Geometry.OCCFixSmallFaces=1; 
Merge "C:\www\ttt\stp_uploads\246.step"; 
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
Physical Surface("support") = {5}; 
Physical Surface("load") = {17}; 
Physical Volume("part") = {1}; 
Mesh.SaveGroupsOfNodes = 1; 
Save "gmsh.inp"; 
Exit; 
