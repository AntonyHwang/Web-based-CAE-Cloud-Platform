import math
import sys
from os.path import dirname, abspath
import os


def process_disp(line, msh):    # writes displacement values to file
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
        msh.write('$EndNodeData\n')
        return 0
    return 1


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
        # calculate and print von Mises stress
        val1 = math.pow(sxx - syy, 2)
        val2 = math.pow(syy - szz, 2)
        val3 = math.pow(szz - sxx, 2)
        val4 = 6 * (math.pow(sxy, 2) + math.pow(syz, 2) + math.pow(szx, 2))
        val = math.sqrt((val1 + val2 + val3 + val4)/2)
        msh.write(str(val) + '\n')
    elif first_num == '-3':  # end of section
        msh.write('$EndNodeData\n')
        return 0
    return 1


def frdToMsh(job_id):
    frd_file = dirname(dirname(abspath(__file__))) + "\\jobs\\" + str(job_id) + "\\solve.frd"
    msh_file = dirname(dirname(abspath(__file__))) + "\\gmsh_output\\" + str(job_id) + ".msh"

    frd = open(frd_file, 'rU')
    msh = open(msh_file, 'a')    # change to w for testing
    num_nodes = '-1'

    status = 0  # 0 for none, 1 for disp, 2 for stress
    for line in frd:
        if status == 1 and process_disp(line, msh) == 0:    # 0 means section ended
            status = 0
        elif status == 2 and process_stress(line, msh) == 0:    # 0 means section ended
            status = 0
        elif status == 0 and line[4:6] == '2C':  # marks node section (depends on there only being 1)
            num_nodes = line.split()[1]  # get number of nodes
        elif status == 0 and len(line) > 16:
            category = line[:17].strip()
            if category == '-4  DISP':
                msh.write('$NodeData\n1\n"Magnitude of displacement"\n1\n0.0\n3\n0\n3\n')
                msh.write(num_nodes + '\n')
                status = 1
            elif category == '-4  STRESS':
                msh.write('$NodeData\n1\n"von Mises stress"\n1\n0.0\n3\n0\n1\n')
                msh.write(num_nodes + '\n')
                status = 2
    frd.close()
    msh.close()


if __name__ == '__main__':
    frdToMsh(sys.argv[1])
    #val = dirname(dirname(abspath(__file__))) + "\\scripts"
    #os.system(val + '\\to_x3d.bat gmsh_output\\{} final_x3d\\{}'.format(sys.argv[1], sys.argv[1]))