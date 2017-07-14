import math
import test

_nodes = []
_elements = []

class Point(object):
    def __init__(self, x, y, z):
        self.x, self.y, self.z = float(x), float(y), float(z)
        self.s = 0

    def getx(self): return self.x
    def gety(self): return self.y
    def getz(self): return self.z

    def getSurface(self): return self.s
    def getPoints(self):  return [self.x,self.y,self.z]

    def addSurface(self, sur):
        self.s = sur

    def distFrom(self, p):
        return math.sqrt((self.x - p.getx()) ** 2 + (self.y - p.gety()) ** 2 + (self.z - p.getz()) ** 2)

    #def distFrom(self, x, y, z):
    #    return math.sqrt((self.x - x) ** 2 + (self.y - y) ** 2 + (self.z - z) ** 2)

class Triangle(object):
    def __init__(self, p1, p2, p3, face):
        self.p1, self.p2, self.p3 = p1, p2, p3

    def printPoints(self):
        print('Point 1 ({}), Point 2 ({}), Point 3 ({})'.format(self.p1.getPoints(), self.p2.getPoints(), self.p3.getPoints()))

    def centroid(self, p1, p2, p3):
        return Point((p1.x + p2.x + p3.x)/3, (p1.y + p2.y + p3.y)/3, (p1.z + p2.z + p3.z)/3)


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
                    x = Point(float(keys[1]), float(keys[2]), float(keys[3]))
                    _nodes.append(x)

                nodesCounter += 1
            elif readingElements:
                if elementsCounter > 1:
                    keys = line.split()
                    if keys[1] == str(2) and len(keys) == 8:
                        x = Triangle(_nodes[int(keys[5]) - 1], _nodes[int(keys[6]) - 1], _nodes[int(keys[7]) - 1], keys[4])
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
    val = test.min3(_nodes, Point(-0.319345442688558,-36.56151783839255,9.980903766262486))
    print(_nodes[val[1][0]].getSurface())
