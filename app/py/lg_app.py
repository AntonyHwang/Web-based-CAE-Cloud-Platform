import sys
import os
from os.path import dirname, abspath
import file_conversion
import msh_to_x3d

def read_nodes(job_id, nodes):
    with open("lc_uploads/node_uploads/" + job_id + ".txt") as node_file:
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
    with open("lc_uploads/element_uploads/" + job_id + ".txt") as element_file:
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

    output = open("lc_output/" + job_id + ".msh","w")
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

def main(job_id, x, y, z):
    nodes = read_nodes(job_id, [])
    total_nodes = nodes[len(nodes) - 1].idx
    elements = read_elements(job_id, [])
    displacement_factor = direction_delta(nodes)
    generate_lattice(job_id, nodes, elements, total_nodes, displacement_factor, x, y, z)
    msh_to_x3d.mshTox3d("lc_output/" + job_id + ".msh")

if __name__ == "__main__":
    job_id = sys.argv[1]
    x = sys.argv[2]
    y = sys.argv[3]
    z = sys.argv[4]
    main(job_id, x, y, z)
