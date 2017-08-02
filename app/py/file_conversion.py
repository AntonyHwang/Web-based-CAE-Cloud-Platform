##Copyright 2010-2017 Thomas Paviot (tpaviot@gmail.com)
##
##This file is part of pythonOCC.
##
##pythonOCC is free software: you can redistribute it and/or modify
##it under the terms of the GNU Lesser General Public License as published by
##the Free Software Foundation, either version 3 of the License, or
##(at your option) any later version.
##
##pythonOCC is distributed in the hope that it will be useful,
##but WITHOUT ANY WARRANTY; without even the implied warranty of
##MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
##GNU Lesser General Public License for more details.
##
##You should have received a copy of the GNU Lesser General Public License
##along with pythonOCC.  If not, see <http://www.gnu.org/licenses/>.

from __future__ import print_function

import sys

from OCC.STEPControl import STEPControl_Reader
from OCC.IFSelect import IFSelect_RetDone, IFSelect_ItemsByEntity
from OCC.Visualization import Tesselator
from OCC.TopExp import TopExp_Explorer
from OCC.TopAbs import TopAbs_FACE

from core_topology_traverse import Topo

def stpTox3d(filename):
    shape = read_step_file('stp_uploads/%s.step' % filename)

    # code taken from http://programtalk.com/vs2/python/13252/pythonocc-core/src/Display/WebGl/x3dom_renderer.py/ and changed
    explorer = TopExp_Explorer()
    explorer.Init(shape, TopAbs_FACE)
    faces = []
    indexed_face_sets = []
    while explorer.More():
        current_face = explorer.Current()
        faces.append(current_face)
        explorer.Next()
    # loop over faces
    for face in faces:
        face_tesselator = Tesselator(face)
        face_tesselator.Compute()
        indexed_face_sets.append(face_tesselator.ExportShapeToX3DIndexedFaceSet())

    # read stuff into file
    f = open('x3d_output/%s.x3d' % filename, 'w')
    # write header (taken from PythonOCC's Visualization/Tesselator.cpp)
    f.write("<?xml version='1.0' encoding='UTF-8'?>")
    f.write("<!DOCTYPE X3D PUBLIC 'ISO//Web3D//DTD X3D 3.1//EN' 'http://www.web3d.org/specifications/x3d-3.1.dtd'>")
    f.write("<X3D>")
    f.write("<Head>")
    f.write("<meta name='generator' content='pythonOCC, http://www.pythonocc.org'/>")
    f.write("</Head><Scene>")
    counter = 1
    for i in indexed_face_sets:
        f.write("<Shape><Appearance><Material DEF='Shape_Mat_{}' diffuseColor='0.65 0.65 0.65' ".format(counter))
        f.write("shininess='0.9' specularColor='1 1 1'></Material></Appearance>\n")
        i = i[:-1]
        f.write(i)
        f.write("</Shape>\n\n")
        counter += 1
    f.write("</Scene></X3D>\n")
    f.close()
    return counter - 1


def read_step_file(filename):
    """ read the STEP file and returns a compound
    """
    step_reader = STEPControl_Reader()
    status = step_reader.ReadFile(filename)

    if status == IFSelect_RetDone:  # check status
        failsonly = False
        step_reader.PrintCheckLoad(failsonly, IFSelect_ItemsByEntity)
        step_reader.PrintCheckTransfer(failsonly, IFSelect_ItemsByEntity)

        ok = step_reader.TransferRoot(1)
        _nbs = step_reader.NbShapes()
        aResShape = step_reader.Shape(1)
    else:
        print("Error: can't read file.")
        sys.exit(0)
    return aResShape
