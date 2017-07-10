#!/bin/sh
#converts a .stp file into a .gmsh using cgx

#file not found
if [ "$#" -lt '#input number here' ]
then
    echo "<< Job not submitted !!"  
    exit
fi

#input file

#STEP
STPFILE = $1


: << when_geo_is_needed
#GEO 
if [ -z "$2" ]
then

#remove gmsh if file exists
if [ -f ${GMSHFILE}.geo ]
then
    /bin/rm ${GMSHFILE}.geo
fi
when_geo_is_needed

#CONVERT TO GMSH
gmsh -3 -o $STPFILE.msh

#output file