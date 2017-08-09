import sys
#### import the simple module from the paraview
from paraview.simple import *

"""
set scale factor to 100
set color to rainbow one
click apply and warp by vector

magick C:\image2.png -crop 194x281+194+0 C:\blah.png
"""


def x3d_convert(job_id):
    #### disable automatic camera reset on 'Show'
    paraview.simple._DisableFirstRenderCameraReset()

    frd_filename = 'C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\jobs\\' + str(job_id) + '\\solve_mmh.vtk'
    # create a new 'Legacy VTK Reader'
    solve_mmhvtk = LegacyVTKReader(FileNames=[frd_filename])

    # set active source
    SetActiveSource(solve_mmhvtk)

    # get active view
    renderView1 = GetActiveViewOrCreate('RenderView')
    # uncomment following to set a specific view size
    # renderView1.ViewSize = [859, 565]

    # get color transfer function/color map for 'a1STRESS'
    a1STRESSLUT = GetColorTransferFunction('a1STRESS')

    # show data in view
    solve_mmhvtkDisplay = Show(solve_mmhvtk, renderView1)
    # trace defaults for the display properties.
    solve_mmhvtkDisplay.ColorArrayName = ['POINTS', '[1]-STRESS']
    solve_mmhvtkDisplay.LookupTable = a1STRESSLUT
    solve_mmhvtkDisplay.ScalarOpacityUnitDistance = 138.3055318925248

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # reset view to fit data
    renderView1.ResetCamera()

    # get opacity transfer function/opacity map for 'a1STRESS'
    a1STRESSPWF = GetOpacityTransferFunction('a1STRESS')

    # export view
    ExportView('C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\final_x3d\\' + str(job_id) + '_stress.x3d', view=renderView1)

    # set scalar coloring
    ColorBy(solve_mmhvtkDisplay, ('POINTS', '[1]-DISP'))

    # rescale color and/or opacity maps used to include current data range
    solve_mmhvtkDisplay.RescaleTransferFunctionToDataRange(True)

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # get color transfer function/color map for 'a1DISP'
    a1DISPLUT = GetColorTransferFunction('a1DISP')

    # get opacity transfer function/opacity map for 'a1DISP'
    a1DISPPWF = GetOpacityTransferFunction('a1DISP')

    # export view
    ExportView('C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\final_x3d\\' + str(job_id) + '_disp.x3d', view=renderView1)

    #### saving camera placements for all active views

    # current camera placement for renderView1
    renderView1.CameraPosition = [7684.019775390625, -2156.6299438476562, 4822.347967186588]
    renderView1.CameraFocalPoint = [7684.019775390625, -2156.6299438476562, 300.0]
    renderView1.CameraParallelScale = 1170.4697824885584

    #### uncomment the following to render all views
    # RenderAllViews()
    # alternatively, if you want to write images, you can use SaveScreenshot(...).


if __name__ == '__main__':
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin")
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin\Lib")
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin/Lib\site-packages")

    if len(sys.argv) != 2:
        print('Wrong number of arguments. Usage: pvpython x3d_convert.py <job_id>')
    elif not(sys.argv[1].isdigit()):
        print('Job ID must be a positive integer. Usage: pvpython x3d_convert.py <job_id>')
    else:
        x3d_convert(sys.argv[1])