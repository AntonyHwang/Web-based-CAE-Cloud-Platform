@echo off

set job_id=%1
set displacement=%2


call "C:\ParaView 4.4.0\bin\pvpython.exe" "C:\www\ttt\py\x3d_convert.py" %*
cd C:\www\ttt\jobs\%job_id%
::"C:\ImageMagick-7.0.6-Q16\magick.exe" C:\www\ttt\jobs\%job_id%\disp_img.png -crop 231x271+749+266 C:\www\ttt\jobs\%job_id%\disp_scale.png
::"C:\ImageMagick-7.0.6-Q16\magick.exe" C:\www\ttt\jobs\%job_id%\stress_img.png -crop 231x271+749+266 C:\www\ttt\jobs\%job_id%\stress_scale.png