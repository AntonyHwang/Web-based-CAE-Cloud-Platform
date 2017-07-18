import face_identifier
import sys
from os.path import exists
import classes

_nodes = []
_elements = []
_centroids = []

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
                    x = classes.Point(float(keys[1]), float(keys[2]), float(keys[3]))
                    _nodes.append(x)

                nodesCounter += 1
            elif readingElements:
                if elementsCounter > 1:
                    keys = line.split()
                    if keys[1] == str(2) and len(keys) == 8:
                        x = classes.Triangle(_nodes[int(keys[5]) - 1], _nodes[int(keys[6]) - 1], _nodes[int(keys[7]) - 1], keys[4])
                        x.center.addSurface(x.face)
                        _centroids.append(x.center)
                        _nodes[int(keys[5]) - 1].addSurface(keys[4])
                        _nodes[int(keys[6]) - 1].addSurface(keys[4])
                        _nodes[int(keys[7]) - 1].addSurface(keys[4])

                        _elements.append(x)
                elementsCounter += 1


if __name__ == "__main__":
    # trying to get path doesn't seem to work on web server
    #path = os.path.dirname(os.getcwd()) + "\\gmsh_output\\" + sys.argv[4] + ".msh";
    path = "C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\gmsh_output\\" + sys.argv[4] + ".msh"

    readFile(path);
    #val = face_identifier.min3(_nodes, classes.Point(-0.319345442688558,-36.56151783839255,9.980903766262486))
    val = face_identifier.min3(_centroids, classes.Point(sys.argv[1], sys.argv[2], sys.argv[3]))
    #print(_nodes[val[1][0]].getSurface())
    #test = open(sys.argv[4] + ".txt", "r+")


    # test = open(sys.argv[4] + ".txt", "ab+")
    # lines = test.readlines()
    #
    # counter = 0
    # check = 0
    # for line in lines:
    #     if line.find("Anchor: ") and int(sys.argv[5]) == 1:
    #         lines[counter] = "Anchor: " + str(_centroids[val[1][0]].getSurface()) + "\n"
    #         check += 1
    #     elif line.find("Pressure: ") and int(sys.argv[5]) == 2:
    #         lines[counter] = "Pressure: " + str(_centroids[val[1][0]].getSurface()) + "\n"
    #         check += 1
    #     counter += 1
    #
    # if check > 0:
    #     test = open(sys.argv[4] + ".txt", "w+")
    #     test.writelines(lines)
    #     test.close()
    # else:
    #     test.close()

    file = open(sys.argv[4] + ".txt", "a+")
    if int(sys.argv[5]) == 1:
        file.write("Point: " +  str(_centroids[val[1][0]].getPoints()) + ", Anchor Surface: " + str(_centroids[val[1][0]].getSurface()) + "\n")
    elif int(sys.argv[5]) == 2:
        file.write("Point: " +  str(_centroids[val[1][0]].getPoints()) + ", Pressure Surface: " + str(_centroids[val[1][0]].getSurface()) + "\n")
    file.close()


