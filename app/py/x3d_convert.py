import sys
#### import the simple module from the paraview
from paraview.simple import *


def x3d_convert(job_id, displacement):
    #### disable automatic camera reset on 'Show'
    paraview.simple._DisableFirstRenderCameraReset()

    vtk_filename = 'C:\\www\\ttt\\jobs\\' + str(job_id) + '\\solve_mmh.vtk'
    # create a new 'Legacy VTK Reader'
    solve_mmhvtk = LegacyVTKReader(FileNames=[vtk_filename])

    # get active view
    renderView1 = GetActiveViewOrCreate('RenderView')
    # uncomment following to set a specific view size
    renderView1.ViewSize = [980, 537]

    # get color transfer function/color map for 'a1STRESS'
    a1STRESSLUT = GetColorTransferFunction('a1STRESS')

    # show data in view
    solve_mmhvtkDisplay = Show(solve_mmhvtk, renderView1)
    # trace defaults for the display properties.
    solve_mmhvtkDisplay.ColorArrayName = ['POINTS', '[1]-STRESS']
    solve_mmhvtkDisplay.LookupTable = a1STRESSLUT
    solve_mmhvtkDisplay.ScalarOpacityUnitDistance = 138.6879366365625

    # reset view to fit data
    renderView1.ResetCamera()

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # get opacity transfer function/opacity map for 'a1STRESS'
    a1STRESSPWF = GetOpacityTransferFunction('a1STRESS')

    # hide data in view
    Hide(solve_mmhvtk, renderView1)

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # Apply a preset using its name. Note this may not work as expected when presets have duplicate names.
    a1STRESSLUT.ApplyPreset('Blue to Red Rainbow', True)

    # current camera placement for renderView1
    renderView1.CameraPosition = [7684.019775390625, -2156.6299438476562, 4822.347967186588]
    renderView1.CameraFocalPoint = [7684.019775390625, -2156.6299438476562, 300.0]
    renderView1.CameraParallelScale = 1170.4697824885584

    # save screenshot
    SaveScreenshot('C:\\www\\ttt\\jobs\\' + str(job_id) + '\\stress_img.png', magnification=1, quality=100, view=renderView1)

    # hide color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, False)

    # set scalar coloring
    ColorBy(solve_mmhvtkDisplay, ('POINTS', '[1]-DISP'))

    # rescale color and/or opacity maps used to include current data range
    solve_mmhvtkDisplay.RescaleTransferFunctionToDataRange(True)

    # get color transfer function/color map for 'a1DISP'
    a1DISPLUT = GetColorTransferFunction('a1DISP')

    # get opacity transfer function/opacity map for 'a1DISP'
    a1DISPPWF = GetOpacityTransferFunction('a1DISP')

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # Apply a preset using its name. Note this may not work as expected when presets have duplicate names.
    a1DISPLUT.ApplyPreset('Blue to Red Rainbow', True)

    # current camera placement for renderView1
    renderView1.CameraPosition = [7684.019775390625, -2156.6299438476562, 4822.347967186588]
    renderView1.CameraFocalPoint = [7684.019775390625, -2156.6299438476562, 300.0]
    renderView1.CameraParallelScale = 1170.4697824885584

    # save screenshot
    SaveScreenshot('C:\\www\\ttt\\jobs\\' + str(job_id) + '\\disp_img.png', magnification=1, quality=100, view=renderView1)

    # hide color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, False)

    # create a new 'Warp By Vector'
    warpByVector1 = WarpByVector(Input=solve_mmhvtk)
    warpByVector1.Vectors = ['POINTS', '[1]-DISP']

    # Properties modified on warpByVector1
    warpByVector1.ScaleFactor = displacement

    # show data in view
    warpByVector1Display = Show(warpByVector1, renderView1)
    # trace defaults for the display properties.
    warpByVector1Display.ColorArrayName = ['POINTS', '[1]-STRESS']
    warpByVector1Display.LookupTable = a1STRESSLUT
    warpByVector1Display.ScalarOpacityUnitDistance = 138.7648345463252

    # reset view to fit data
    renderView1.ResetCamera()

    # hide data in view
    Hide(solve_mmhvtk, renderView1)

    # show color bar/color legend
    warpByVector1Display.SetScalarBarVisibility(renderView1, True)

    # save screenshot
    SaveScreenshot('C:\\www\\ttt\\jobs\\' + str(job_id) + '\\stress_ss.png', magnification=1, quality=100, view=renderView1)

    # export view
    ExportView('C:\\www\\ttt\\final_x3d\\' + str(job_id) + '_stress.x3d', view=renderView1)

    # show color bar/color legend
    warpByVector1Display.SetScalarBarVisibility(renderView1, False)

    # Properties modified on warpByVector1
    warpByVector1.ScaleFactor = displacement

    # set scalar coloring
    ColorBy(warpByVector1Display, ('POINTS', '[1]-DISP'))

    # rescale color and/or opacity maps used to include current data range
    warpByVector1Display.RescaleTransferFunctionToDataRange(True)

    # show color bar/color legend
    warpByVector1Display.SetScalarBarVisibility(renderView1, True)

    # save screenshot
    SaveScreenshot('C:\\www\\ttt\\jobs\\' + str(job_id) + '\\disp_ss.png', magnification=1, quality=100, view=renderView1)

    # export view
    ExportView('C:\\www\\ttt\\final_x3d\\' + str(job_id) + '_disp.x3d', view=renderView1)

    #### saving camera placements for all active views

    # current camera placement for renderView1
    renderView1.CameraPosition = [7684.020263671875, -2156.630615234375, 4823.959268216383]
    renderView1.CameraFocalPoint = [7684.020263671875, -2156.630615234375, 299.1031900048256]
    renderView1.CameraParallelScale = 1171.1189293890523

    #### uncomment the following to render all views
    # RenderAllViews()
    # alternatively, if you want to write images, you can use SaveScreenshot(...).


if __name__ == '__main__':
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin")
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin\Lib")
    # sys.path.append("C:/Program Files/ParaView 5.4.1/bin/Lib\site-packages")

    if len(sys.argv) != 3:
        print('Wrong number of arguments. Usage: pvpython x3d_convert.py <job_id> <displacement>')
    elif not(sys.argv[1].isdigit()):
        print('Job ID must be a positive integer. Usage: pvpython x3d_convert.py <job_id> <displacement>')
    else:
        x3d_convert(sys.argv[1], float(sys.argv[2]))