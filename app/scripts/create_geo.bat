@echo off

::job_id is the first parameter
set job_id = %1 

::support and load parameters
set supp = %2
set load = %3

::delete job_id.geo if exists
if exist "%job_id%.geo" del "%job_id%.geo"

::set GMSH pre-processing script
(
    // Geometry.Tolerance=0.1;
    //Geometry.OCCFixSmallEdges=1;
    //Geometry.OCCFixSmallFaces=1;
    Merge "part.step";
    // Mesh control
    Mesh.ElementOrder=2;
    Mesh.Optimize=1;
    // Display control
    //Mesh.SurfaceEdges = 1;
    Mesh.SurfaceFaces = 1;
    Mesh.VolumeEdges = 0;
    //Mesh.VolumeFaces = 0;
    Mesh 3;
    Physical Surface("support") = {%supp%};
    Physical Surface("load") = {%load%};
    Physical Volume("part") = {1};
    Mesh.SaveGroupsOfNodes = 1;
)>"%job_id%.geo"
