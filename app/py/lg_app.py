import sys
from os.path import dirname, abspath
import msh_to_x3d

val =  dirname(dirname(abspath(__file__)))

class Lattice(object):
    def __init__(self, elements, nodes):
        self.elements, self.nodes = elements, nodes


class Element(object):
    def __init__(self, n1, n2, n3):
        self.n1, self.n2, self.n3 = n1, n2, n3

    def toString(self):
        return "(" + str(self.n1) + "," + str(self.n2) + "," + str(self.n3) + ")"


class Node(object):
    def __init__(self, idx, x, y, z):
        self.idx, self.x, self.y, self.z = idx, x, y, z

    def __hash__(self):
        return hash((self.x, self.y, self.z))

    def __eq__(self, other):
        return self.x == other.x and self.y == other.y and self.z == other.z

    def toString(self):
        return "(" + str(self.x) + "," + str(self.y) + "," + str(self.z) + ")"


def is_number(s):
    try:
        float(s)
        return True
    except ValueError:
        return False

def read_nodes(job_id, nodes):
    with open(val + "/lg_uploads/node_uploads/" + str(job_id) + ".txt") as node_file:
        for line in node_file:
            if not line.strip():
                continue
            else:
                words = line.split()
                if is_number(words[0]):
                    nodes.append(Node(int(words[0]),float(words[1]), float(words[2]), float(words[3])))
    node_file.close()
    return nodes

def read_elements(job_id, elements):
    global ELEMENT_ATTRIBUTES
    flag = False
    with open(val + "/lg_uploads/element_uploads/" + str(job_id) + ".txt") as element_file:
        for line in element_file:
            if not line.strip():
                continue
            else:
                words = line.split()
                if is_number(words[0]):
                    if not flag:
                        #ELEMENT_ATTRIBUTES = words[1] + " " + words[2] + " " + words[3] + " " + words[4]
                        ELEMENT_ATTRIBUTES = "2 2 3 4"
                        flag = True
                    elements.append(Element(int(words[6]), int(words[7]), int(words[8])))
    element_file.close()
    return elements

def direction_delta(nodes):
    maxX = max(node.x for node in nodes)
    minX = min(node.x for node in nodes)
    maxY = max(node.y for node in nodes)
    minY = min(node.y for node in nodes)
    maxZ = max(node.z for node in nodes)
    minZ = min(node.z for node in nodes)
    return Node(0, maxX - minX, maxY - minY, maxZ - minZ)

def generate_lattice(job_id, nodes, elements, total_nodes, displacement_factor, x, y, z):
    model = Lattice(elements, nodes)

    output = open(val + "/lg_output/msh/" + str(job_id) + ".msh","w")
    output.write("$MeshFormat\n")
    # MESH FORMAT
    output.write("2.2 0 8\n")
    output.write("$EndMeshFormat\n$Nodes\n")
    # WRITE NODES HERE
    # NUM OF NODES
    output.write(str(((x) * (y) * (z)) * len(model.nodes)) + "\n")

    multiplier = 0
    count = 0

    for num1 in range(0,x):
        for num2 in range (0,y):
            for num3 in range(0,z):
                count +=1
                for n in model.nodes:
                    output.write(str(n.idx + total_nodes * multiplier) +
                                 " " + str(n.x + num1 * displacement_factor.x) +
                                 " " + str(n.y + num2 * displacement_factor.y) +
                                 " " + str(n.z + num3 * displacement_factor.z) + '\n')
                multiplier += 1
    
    # Elements
    output.write("$EndNodes\n$Elements\n")

    output.write(str((x * y * z) * len(model.elements)) + "\n")
    multiplier = 0
    count = 0
    index = 0
    for num1 in range(0,x):
        for num2 in range (0,y):
            for num3 in range(0,z):
                for e in model.elements:
                    index += 1
                    count += 1
                    output.write(str(index) + " " + ELEMENT_ATTRIBUTES + 
                                       " " + str(e.n1 + multiplier * total_nodes) + 
                                       " " + str(e.n2 + multiplier * total_nodes) + 
                                       " " + str(e.n3 + multiplier * total_nodes) + '\n')
                multiplier +=1
    output.write("$EndElements\n")
    output.close()

if __name__ == "__main__":
    job_id = sys.argv[1]
    x = int(sys.argv[2])
    y = int(sys.argv[3])
    z = int(sys.argv[4])
    # job_id = 4
    # x = 2
    # y = 2
    # z = 2
    nodes = read_nodes(job_id, [])
    total_nodes = nodes[len(nodes) - 1].idx
    elements = read_elements(job_id, [])
    displacement_factor = direction_delta(nodes)
    generate_lattice(job_id, nodes, elements, total_nodes, displacement_factor, x, y, z)
    msh_to_x3d.mshTox3d(job_id)
    print("finished")
