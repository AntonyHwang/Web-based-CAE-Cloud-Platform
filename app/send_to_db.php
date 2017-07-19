<!DOCTYPE html>

<?php
    require ("includes/config.php");
?>

<html>
    <head>
        <h1>This is Sample Text to Display!</h1>
    </head>

    <body>
        <?php
            $density =  $_POST["density"];
            $youngs_mod = $_POST["youngs_mod"];
            $poissons = $_POST["poissons"];
            $element_size = $_POST["element_size"];
            $material =  $_POST["material"];
            $id =  $_POST["id"];
            $a_x = $_POST["a_x"];
            $a_y = $_POST["a_y"];
            $a_z = $_POST["a_x"];
            $p_x = $_POST["p_x"];
            $p_y = $_POST["p_y"];
            $p_z = $_POST["p_x"];
            
        ?>
    </body>

</html>

<?php
    // $required = array('density', "youngs_mod", "poissons", "element_size", "material")
    // foreach($required as $element) {

    //     if (empty($_POST[$element])) {

    //     }
    // }
    //$sql_update = "UPDATE job SET (density, youngs_mod, poissons_ratio, element_size, material_name) VALUE ('".$_POST["density"]."', '".$_POST["youngs_mod"]."','".$_POST["poissons"]."','".$_POST["element_size"]."','".$_POST["material"]."') WHERE job_id = $_POST["id"]";


    $sql_update = "UPDATE job SET density = '$density', element_size = '$element_size', youngs_mod = '$youngs_mod', poissons_ratio = '$poissons', material_name = '$material', anchor_x = '$a_x', anchor_y = '$a_y', anchor_z = '$a_z', pressure_x = '$p_x', pressure_y = '$p_y', pressure_z = '$p_z' WHERE job_id = '$id'";
    $sth = $dbh->query($sql_update);
    $sth = null; 

    
?>