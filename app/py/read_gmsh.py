import face_identifier
import sys
import classes

_nodes = []
_elements = []

def readFile():
    readingNodes = False
    nodesCounter = 0

    readingElements = False
    elementsCounter = 0
    with open('C:\Users\MD580\Desktop\part.msh') as f:
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
                        _nodes[int(keys[5]) - 1].addSurface(keys[4])
                        _nodes[int(keys[6]) - 1].addSurface(keys[4])
                        _nodes[int(keys[7]) - 1].addSurface(keys[4])

                        _elements.append(x)
                elementsCounter += 1

    #for point in _nodes:
        #point.printPoints()
   # for element in _elements:
        #element.printPoints()



if __name__ == "__main__":
    readFile()
    #val = face_identifier.min3(_nodes, classes.Point(-0.319345442688558,-36.56151783839255,9.980903766262486))
    val = face_identifier.min3(_nodes, classes.Point(sys.argv[1], sys.argv[2], sys.argv[3]))
    #print(_nodes[val[1][0]].getSurface())
    test = open("testfile.txt", "wb")
    test.write(_nodes[val[1][0]].getSurface())
    test.close()