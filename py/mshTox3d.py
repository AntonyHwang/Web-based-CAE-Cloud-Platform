import sys
from os.path import exists, abspath, dirname

_nodes = []
_tetras = []
_lines = set()

# requires consecutive node numbers
def readFile(msh_file):
    readingNodes = False
    nodesCounter = 0

    readingElements = False
    elementsCounter = 0
    with open(msh_file) as f:
        for line in f:
            if line.startswith('$Nodes'):
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
                    if keys[1] == str(4) and len(keys) == 9:
                        # get tetra vertex node numbers and put 4-tuple in list
                        quad_tuple = (int(keys[5]) - 1, int(keys[6]) - 1, int(keys[7]) - 1, int(keys[8]) - 1)
                        _tetras.append(quad_tuple)
                elementsCounter += 1

    # for every tetra, add 4 lines in line set
    # use frozensets so (a, b) is equivalent to (b, a)
    for tetra in _tetras:
        line = frozenset((tetra[0], tetra[1]))
        _lines.add(line)
        line = frozenset((tetra[0], tetra[2]))
        _lines.add(line)
        line = frozenset((tetra[0], tetra[3]))
        _lines.add(line)
        line = frozenset((tetra[1], tetra[2]))
        _lines.add(line)
        line = frozenset((tetra[1], tetra[3]))
        _lines.add(line)
        line = frozenset((tetra[2], tetra[3]))
        _lines.add(line)


def mshTox3d(job_id):
    frd_file = dirname(dirname(abspath(__file__))) + "\\jobs\\" + str(job_id) + "\\solve.frd"
    msh_file = dirname(dirname(abspath(__file__))) + "\\final_x3d\\" + str(job_id) + ".x3d"


    readFile(frd_file)
    # read stuff into file
    f = open(msh_file, 'w')
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


if __name__ == "__main__":
   mshTox3d(218)