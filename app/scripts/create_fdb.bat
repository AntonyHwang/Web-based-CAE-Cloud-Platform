@echo off

::job_id is the first parameter
set job_id = %1 

(
    ## PRE-PROCESSING
    sys gmsh %jobid%.geo
    read gmsh.inp

    # remove surface elements
    zap +CPS6

    send all abq
    send support abq nam
    comp load do
    send load abq pres 1

    plot f load
    plus n support
    hcpy png
    sys mv hcpy_1.png Refs/sets.png

    sys ccx solve

    ## POST-PROCESSING
    read solve.frd

    rot y
    rot c 30
    rot r 30
    view disp
    scal d 1000
    view elem
    ds -0 e 7
    plot fv all
    hcpy png
    sys mv hcpy_2.png Refs/se.png
    rot y
    rot u 30
    plot f all n
    hcpy png
    sys mv hcpy_3.png Refs/disp.png
)>"%job_id%.fbd"