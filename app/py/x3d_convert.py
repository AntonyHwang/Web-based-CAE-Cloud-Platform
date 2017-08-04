import sys
from paraview.simple import *

# need to alter for stress one too!
def x3d_convert(job_id):
    #### disable automatic camera reset on 'Show'
    paraview.simple._DisableFirstRenderCameraReset()

    frd_filename = 'C:\\Users\\MD580\\Desktop\\Web-based-CAE-Cloud-Platform\\app\\jobs\\' + str(job_id) + '\\solve_mmh.vtk'

    # create a new 'Legacy VTK Reader'
    solve_mmhvtk = LegacyVTKReader(
        FileNames=[frd_filename])

    # set active source
    SetActiveSource(solve_mmhvtk)

    # get active view
    renderView1 = GetActiveViewOrCreate('RenderView')
    # uncomment following to set a specific view size
    # renderView1.ViewSize = [971, 566]

    # get color transfer function/color map for 'a1STRESSSXX'
    a1STRESSSXXLUT = GetColorTransferFunction('a1STRESSSXX')

    # get opacity transfer function/opacity map for 'a1STRESSSXX'
    a1STRESSSXXPWF = GetOpacityTransferFunction('a1STRESSSXX')

    # show data in view
    solve_mmhvtkDisplay = Show(solve_mmhvtk, renderView1)
    # trace defaults for the display properties.
    solve_mmhvtkDisplay.Representation = 'Surface'
    solve_mmhvtkDisplay.ColorArrayName = ['POINTS', '[1]-STRESS-SXX']
    solve_mmhvtkDisplay.LookupTable = a1STRESSSXXLUT
    solve_mmhvtkDisplay.OSPRayScaleArray = '[1]-STRESS-SXX'
    solve_mmhvtkDisplay.OSPRayScaleFunction = 'PiecewiseFunction'
    solve_mmhvtkDisplay.SelectOrientationVectors = '[1]-DISP'
    solve_mmhvtkDisplay.ScaleFactor = 15.240000000000002
    solve_mmhvtkDisplay.SelectScaleArray = '[1]-STRESS-SXX'
    solve_mmhvtkDisplay.GlyphType = 'Arrow'
    solve_mmhvtkDisplay.GlyphTableIndexArray = '[1]-STRESS-SXX'
    solve_mmhvtkDisplay.DataAxesGrid = 'GridAxesRepresentation'
    solve_mmhvtkDisplay.PolarAxes = 'PolarAxesRepresentation'
    solve_mmhvtkDisplay.ScalarOpacityFunction = a1STRESSSXXPWF
    solve_mmhvtkDisplay.ScalarOpacityUnitDistance = 23.056611540729286
    solve_mmhvtkDisplay.GaussianRadius = 7.620000000000001
    solve_mmhvtkDisplay.SetScaleArray = ['POINTS', '[1]-STRESS-SXX']
    solve_mmhvtkDisplay.ScaleTransferFunction = 'PiecewiseFunction'
    solve_mmhvtkDisplay.OpacityArray = ['POINTS', '[1]-STRESS-SXX']
    solve_mmhvtkDisplay.OpacityTransferFunction = 'PiecewiseFunction'

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # reset view to fit data
    renderView1.ResetCamera()

    # set scalar coloring
    ColorBy(solve_mmhvtkDisplay, ('POINTS', '[1]-DISP', 'Magnitude'))

    # Hide the scalar bar for this color map if no visible data is colored by it.
    HideScalarBarIfNotNeeded(a1STRESSSXXLUT, renderView1)

    # rescale color and/or opacity maps used to include current data range
    solve_mmhvtkDisplay.RescaleTransferFunctionToDataRange(True, False)

    # show color bar/color legend
    solve_mmhvtkDisplay.SetScalarBarVisibility(renderView1, True)

    # get color transfer function/color map for 'a1DISP'
    a1DISPLUT = GetColorTransferFunction('a1DISP')

    # export view
    ExportView('C:/Users/MD580/Desktop/Web-based-CAE-Cloud-Platform/app/final_x3d/' + str(job_id) + '.x3d', view=renderView1)

    #### saving camera placements for all active views

    # current camera placement for renderView1
    renderView1.CameraPosition = [180.4726340106879, -351.3045661035108, 183.31634729659532]
    renderView1.CameraFocalPoint = [34.92499923706055, 0.0, 28.57500171661377]
    renderView1.CameraViewUp = [0.27661536418792926, 0.4810422368057717, 0.8319148434209352]
    renderView1.CameraParallelScale = 106.25582439570054

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