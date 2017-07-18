<?php
  $coordX = $_POST["pointX"];
  $coordY = $_POST["pointY"];
  $coordZ = $_POST["pointZ"];
  $id = $_POST["job_id"];
  $click = $_POST["click"];

  $call_python = "C:/Users/MD580/Miniconda2/python.exe py/read_gmsh.py ".$coordX." ".$coordY." ".$coordZ." ".$id." ".$click;
  $result = shell_exec($call_python);

?>