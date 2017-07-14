from functools import partial
import read_gmsh

INFINITE_DIST = read_gmsh.Point(float("inf"),float("inf"),float("inf"))

def minimum_distance(n,ps,p):
    mins = []
    inds = []

    while len(inds) < n:
        dists = [p.distFrom(point) for point in ps]

        inds += [i for i in range(len(dists)) if dists[i] == min(dists)]
        mins += (len(inds)-len(mins)) * [min(dists)]

        ps = [INFINITE_DIST if i in inds else ps[i] for i in range(len(ps))]


    return (mins[:n],inds[:n])

min3 = partial(minimum_distance,3)
