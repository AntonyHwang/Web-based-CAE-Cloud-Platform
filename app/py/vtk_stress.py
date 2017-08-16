import math
import sys


def vtk_stress(job_id):
    vtk = open('C:/www/ttt/jobs/' + str(job_id) + '/solve_mmh.vtk', 'rU')
    vtk_lines = vtk.readlines()
    vtk.close()

    stress_vals = dict()
    stress_vals['SXX'] = []
    stress_vals['SYY'] = []
    stress_vals['SZZ'] = []
    stress_vals['SXY'] = []
    stress_vals['SYZ'] = []
    stress_vals['SZX'] = []

    which_list = ''
    current_list = stress_vals['SXX']
    stress_start = -1
    len_lines = len(vtk_lines)

    for i in range(len_lines):
        line = vtk_lines[i].split()
        if len(line) > 0:
            if line[0] == 'SCALARS':
                if stress_start == -1:
                    stress_start = i
                which_list = line[1].split('-')[2]
                current_list = stress_vals[which_list]
            elif stress_start > -1 and line[0] != 'LOOKUP_TABLE':
                current_list.append(float(line[0]))
        i += 1

    vtk_lines = vtk_lines[:stress_start]    # throw away old stress sections
    vtk_lines.append('SCALARS [1]-STRESS double\n')
    vtk_lines.append('LOOKUP_TABLE default\n')

    # do calculations and add all the values
    for j in range(len(current_list)):
        val1 = math.pow(stress_vals['SXX'][j] - stress_vals['SYY'][j], 2)
        val2 = math.pow(stress_vals['SYY'][j] - stress_vals['SZZ'][j], 2)
        val3 = math.pow(stress_vals['SZZ'][j] - stress_vals['SXX'][j], 2)
        val4 = 6 * (math.pow(stress_vals['SXY'][j], 2) + math.pow(stress_vals['SYZ'][j], 2) + math.pow(stress_vals['SZX'][j], 2))
        val = math.sqrt((val1 + val2 + val3 + val4) / 2)
        if val > 0:
            val = '  ' + str(val)
        else:
            val = ' ' + str(val)
        vtk_lines.append(val + '\n')
        j += 1

    vtk = open('C:/www/ttt/jobs/' + str(job_id) + '/solve_mmh.vtk', 'w+')
    vtk.writelines(vtk_lines)
    vtk.close()


if __name__ == '__main__':
    if len(sys.argv) != 2:
        print('Wrong number of arguments. Usage: python vtk_stress.py <job_id>')
    elif not(sys.argv[1].isdigit()):
        print('Job ID must be a positive integer. Usage: python vtk_stress.py <job_id>')
    else:
        vtk_stress(sys.argv[1])
