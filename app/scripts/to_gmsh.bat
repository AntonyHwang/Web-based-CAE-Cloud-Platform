@echo off
Job = $1

gmsh -2 $Job.step -o $Job.msh