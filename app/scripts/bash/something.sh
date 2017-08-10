#!/bin/sh

# job_id is the first parameter
job_id=$1

# support and load parameters for creating job_id.geo
anchors=$2
pressures=$3

# create inp parameter
youngs_mod=$4
poissons=$5
material=$6

cls=$7

mkdir jobs/$job_id
cd jobs/$job_id

# run scripts that create job_id.fdb, job_id.geo and solve.inp
create_geo.sh $job_id $anchors $pressures $cls
create_fbd.sh $job_id
create_inp $youngs_mod $poissons $material $job_id

# path
source /calculix/path/

exec stuff




