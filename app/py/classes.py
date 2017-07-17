import math

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