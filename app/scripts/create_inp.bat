@echo off

set youngs_mod=%1
set poissons=%2
set material=%3
set id=%4

echo *include,input=all.msh > "solve.inp"
echo *include,input=support.nam >> "solve.inp"
echo ** symmetry at bottom >> "solve.inp"
echo *boundary >> "solve.inp"
echo Nsupport,1,3 >> "solve.inp"
echo ** material definition >> "solve.inp"
echo *material, name= %material% >> "solve.inp"
echo *elastic >> "solve.inp"
echo %youngs_mod%,%poissons%,0 >> "solve.inp"
echo *solid section, elset=Eall, material=%material% >> "solve.inp"
echo *STEP >> "solve.inp"
echo *STATIC >> "solve.inp"
echo *dload >> "solve.inp"
echo *include,input=load.dlo >> "solve.inp"
echo *el file >> "solve.inp"
echo S>> "solve.inp"
echo *node file >> "solve.inp"
echo U >> "solve.inp"
echo *end step >> "solve.inp"
