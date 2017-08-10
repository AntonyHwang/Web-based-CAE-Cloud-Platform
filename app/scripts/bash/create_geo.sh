#!/bin/sh

job_id=$1

anchors=$2
pressures=$3

anchors= "$anchors" | tr -d '"'
pressures= "$pressures" | tr -d '"'

cat << END_OF_CAT > $job_id.geo

#GMSHCODE

END_OF_CAT