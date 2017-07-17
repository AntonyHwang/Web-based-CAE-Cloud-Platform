<?php
  $coordX = $_POST["pointX"];
  $coordY = $_POST["pointY"];
  $coordZ = $_POST["pointZ"];

  $call_python = "C:/Users/MD580/Miniconda2/python.exe py/read_gmsh.py ".$coordX." ".$coordY." ".$coordZ;
  $result = shell_exec($call_python);

?>