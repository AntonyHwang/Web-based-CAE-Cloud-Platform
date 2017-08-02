import math

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


# helper function of frdToMsh
# return value: whether you're at the end of the section or not (yes = 0, no = 1)
def process_disp(line, msh):    # writes displacement values to file (msh = file handle)
    first_num = line[1:3]
    if first_num == '-1':  # node info
        line = line.strip()
        node_num = line[2:12].strip()
        msh.write(node_num + ' ')
        place = 12
        for i in range(3):
            data = line[place:(place + 12)].strip()     # each value takes up 12 spaces
            msh.write(data + ' ')
            place += 12
        msh.write('\n')
    elif first_num == '-3':  # end of section
        return 0
    return 1


# helper function of frdToMsh
# return value: whether you're at the end of the section or not (yes = 0, no = 1)
def process_stress(line, msh):      # calculates von Mises stress and writes to file
    first_num = line[1:3]
    if first_num == '-1':  # node info
        line = line.strip()
        node_num = line[2:12].strip()
        msh.write(node_num + ' ')
        sxx = float(line[12:24])    # each value takes up 12 spaces
        syy = float(line[24:36])
        szz = float(line[36:48])
        sxy = float(line[48:60])
        syz = float(line[60:72])
        szx = float(line[72:84])
        # calculate and write von Mises stress
        val1 = math.pow(sxx - syy, 2)
        val2 = math.pow(syy - szz, 2)
        val3 = math.pow(szz - sxx, 2)
        val4 = 6 * (math.pow(sxy, 2) + math.pow(syz, 2) + math.pow(szx, 2))
        val = math.sqrt((val1 + val2 + val3 + val4)/2)
        msh.write(str(val) + '\n')
    elif first_num == '-3':  # end of section
        return 0
    return 1


# parameters: .frd file name, file name of msh you'll write to, number of nodes (string)
def frdToMsh(frd_name, msh_name, num_nodes):
    frd = open(frd_name, 'rU')
    msh = open(msh_name, 'a')

    status = 0  # 0 for none, 1 for disp, 2 for stress
    for line in frd:
        if status == 1 and process_disp(line, msh) == 0:    # 0 means section ended
            msh.write('$EndNodeData\n')
            status = 0
        elif status == 2 and process_stress(line, msh) == 0:    # 0 means section ended
            msh.write('$EndNodeData\n')
            status = 0
        elif status == 0 and len(line) > 16:
            category = line.split()
            if category[0] == '-4':
                if category[1] == 'DISP':
                    msh.write('$NodeData\n1\n"Magnitude of displacement"\n1\n0.0\n3\n0\n3\n')
                    msh.write(num_nodes + '\n')
                    status = 1
                elif category[1] == 'STRESS':
                    msh.write('$NodeData\n1\n"von Mises stress"\n1\n0.0\n3\n0\n1\n')
                    msh.write(num_nodes + '\n')
                    status = 2
    frd.close()
    msh.close()


# parameters: name of .frd file, name of all.msh file, name of msh file you want to write to
def make_result_mesh(frd_name, all_msh_name, write_msh_name):
    num_nodes = read_all_msh(all_msh_name, write_msh_name)
    frdToMsh(frd_name, write_msh_name, num_nodes)

# if __name__ == '__main__':
#     make_result_mesh('C:/Users/MD580/Desktop/Web-based-CAE-Cloud-Platform/app/jobs/202/solve.frd',
#                      'C:/Users/MD580/Desktop/Web-based-CAE-Cloud-Platform/app/jobs/202/all.msh',
#                      'C:/myfile.msh')
