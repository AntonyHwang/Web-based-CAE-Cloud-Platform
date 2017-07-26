<?php

    require ("includes/config.php");
    
    while(true) {

        $id = $_POST['id'];
        if(!$id) { 
            sleep(10); 
        } else {
            $job = $dbh->prepare("SELECT density,element_size,youngs_mod, poissons_ratio FROM job WHERE id=:id");
            $job->execute(array(":id" => $id));
            $job_row = $job -> fetch(PDO::FETCH_ASSOC);

#################################################################YOUR CODE HERE##################################################################################################
            $face = $dbh->prepare("SELECT  FROM faces WHERE id=:id");
            $face->execute(array(":id" => $id));
            $face_row = $face -> fetch(PDO::FETCH_ASSOC);
            
            chdir();
            system("cmd /c /scripts/create.bat {$id} {$face_row['pressure']} {$face_row['support']} {$job_row['youngs_mod']} {$job_row['poissons']} {$job_row['material']}");
#################################################################YOUR CODE ENDS##################################################################################################


        }



    // output
    

    }
?>