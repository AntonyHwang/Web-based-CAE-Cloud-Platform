import sys
from os.path import dirname, abspath

_nodes = []
_triangles = []
_lines = set()

val =  dirname(dirname(abspath(__file__)))

# requires consecutive node numbers
def readFile(msh_file):
    readingNodes = False
    nodesCounter = 0

    readingElements = False
    elementsCounter = 0
    with open(msh_file) as f:
        for line in f:
            if  line.startswith('$Nodes'):
                readingNodes = True
            elif line.startswith('$Elements'):
                readingElements = True
            elif line.startswith('$EndNodes'):
                readingNodes = False
            elif line.startswith('$EndElements'):
                readingElements = False
            if readingNodes:
                if nodesCounter > 1:
                    keys = line.split()
                    x = (float(keys[1]), float(keys[2]), float(keys[3]))
                    _nodes.append(x)

                nodesCounter += 1
            elif readingElements:
                if elementsCounter > 1:
                    keys = line.split()
                    if keys[1] == str(2) and len(keys) == 8:
                        # get triangle vertex node numbers and put tuple in list
                        tri_tuple = (int(keys[5]) - 1, int(keys[6]) - 1, int(keys[7]) - 1)
                        _triangles.append(tri_tuple)
                elementsCounter += 1

    # for every triangle, add 3 lines in line set
    # use frozensets so (a, b) is equivalent to (b, a)
    for triangle in _triangles:
        line = frozenset((triangle[0], triangle[1]))
        _lines.add(line)
        line = frozenset((triangle[1], triangle[2]))
        _lines.add(line)
        line = frozenset((triangle[0], triangle[2]))
        _lines.add(line)

def mshTox3d(job_id):
    readFile(val + "/lg_output/msh/" + str(job_id) + ".msh")
    # read stuff into file
    f = open(val + "/lg_output/x3d/" + str(job_id) + ".x3d", 'w')
    # write header (taken from PythonOCC's Visualization/Tesselator.cpp)
    f.write("<?xml version='1.0' encoding='UTF-8'?>")
    f.write("<!DOCTYPE X3D PUBLIC 'ISO//Web3D//DTD X3D 3.1//EN' 'http://www.web3d.org/specifications/x3d-3.1.dtd'>")
    f.write("<X3D>")
    f.write("<Head>")
    f.write("<meta name='generator' content='pythonOCC, http://www.pythonocc.org'/>")
    f.write("</Head><Scene>\n")
    f.write("<Shape><Appearance><Material DEF='Shape_Mat' /></Appearance>\n")
    f.write("<IndexedLineSet coordIndex='")
    # iterate over set, adding lines to indexed line set
    for line in _lines:
        for end in line:
            f.write(str(end) + ' ')
        f.write(str(-1) + ' ')
    f.write("'>\n<Coordinate point='")
    # iterate over nodes
    for node in _nodes:
        f.write(str(node[0]) + ' ' + str(node[1]) + ' ' + str(node[2]) + ' ')
    f.write("'/></IndexedLineSet>\n")
    f.write("</Shape>\n")
    f.write("</Scene></X3D>\n")
    f.close()

