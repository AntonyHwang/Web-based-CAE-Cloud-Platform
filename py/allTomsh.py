import sys
from os.path import exists

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
                    if keys[1] == str(11) and len(keys) == 15:
                        deca_tuple = (int(keys[5]) - 1, int(keys[6]) - 1, int(keys[7]) - 1, int(keys[8]) - 1, int(keys[9]) - 1, int(keys[10]) - 1, int(keys[11]) - 1, int(keys[12]) - 1, int(keys[13]) - 1, int(keys[14]) - 1)
                        _tetras.append(deca_tuple)
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
        


def mshTox3d(filename, job_id):
    readFile(filename)
    # read stuff into file
    f = open('C:\\www\\ttt\\gmsh_output\\{}\\mesh.x3d'.format(job_id), 'w')
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


# parameters: all.msh file name, file name of msh you'll write to
# returns: number of nodes as a string (needed for NodeData sections)
def read_all_msh(all_msh_name, write_msh_name):
    all_msh = open(all_msh_name, 'rU')
    write_msh = open(write_msh_name, 'w')
    nodeline = []
    elemline = []
    status = 0  # 0 for none, 1 for nodes, 2 for elements

    for line in all_msh:
        line = line.strip().split(',')
        if len(line) > 3:
            if status == 1:  # node numbers not included
                nodeline.append(line[1] + ' ' + line[2] + ' ' + line[3])
            elif status == 2:   # elem numbers included
                elem = line[0].strip() + ' 11 2 0 1 '   # 11 for 10-point tetrahedron
                for i in line[1:9]:
                    elem += i.strip() + ' '
                elem += line[10].strip() + ' ' + line[9].strip()    # change order of last 2 for gmsh format
                elemline.append(elem)
        else:
            if line[0] == '*NODE':
                status = 1
            elif line[0] == '*ELEMENT':
                status = 2

    # write preliminary stuff
    write_msh.write('$MeshFormat\n2.2 0 8\n$EndMeshFormat\n')

    # write nodes
    num_nodes = len(nodeline)
    write_msh.write('$Nodes\n' + str(num_nodes) + '\n')
    i = 0
    while i < num_nodes:
        write_msh.write(str(i + 1) + ' ' + nodeline[i] + '\n')
        i += 1
    write_msh.write('$EndNodes\n')

    # write elements
    num_elems = len(elemline)
    write_msh.write('$Elements\n' + str(num_elems) + '\n')
    for j in elemline:
        write_msh.write(j + '\n')
    write_msh.write('$EndElements\n')

    all_msh.close()
    write_msh.close()
    return str(num_nodes)

def checkFile(job_id):
    file = "C:\\www\\ttt\\gmsh_output\\{}\\all.msh".format(job_id)
    counter = 0
    with open(file) as f:
        
        for line in f:
            counter += 1
            if "*ELEMENT" in line:
                return True

    if counter <= 2:
        return False

if __name__ == "__main__":
    job_id = sys.argv[1]
    if (checkFile(job_id)):
        read_all_msh("C:\\www\\ttt\\gmsh_output\\{}\\all.msh".format(job_id), "C:\\www\\ttt\\gmsh_output\\{}\\temp.msh".format(job_id))
        mshTox3d("C:\\www\\ttt\\gmsh_output\\{}\\temp.msh".format(job_id), job_id)
        print("success")
    else:
        print("fail")