<?php 
    require "includes/config.php"; 
?>
<html>
    <head></head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- logo -->
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">CAE Cloud Platform</a>
                </div>
                <!-- menu items -->
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="login.php">Login</a></li>
                        <li class="active"><a href="register.php">Register</a></li>
                    </ul>
                </div>

        </nav>
        <table class="table table-striped">                     
            <div class="table responsive">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Job ID</th>
                    <th>File</th>
                    <th>Material</th>
                    <th>Element size</th>
                    <th>Youngs mod</th>
                    <th>Poisson ratio</th>
                    <th>Density</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Del</th>
                    </tr>
                </thead>
                <tbody>
        <?php 
            $select_jobs_sql = "SELECT * FROM job WHERE id_user = ".$_SESSION["id"];
            $get_jobs = $dbh->query($select_jobs_sql); 
            $count = 0;
            // output data of each row
            while($row = $get_jobs->fetch()) {
                $count++;
                echo '<tr>
                        <td scope="row">'.$count.'</td>
                        <td>' . $row["job_id"] .'</td>
                        <td>' . $row["stp_filename"] .'</td>
                        <td> '.$row["material_name"] .'</td>
                        <td> '.$row["element_size"] .'</td>
                        <td> '.$row["young_mod"] .'</td>
                        <td> '.$row["poissons_ratio"] .'</td>
                        <td> '.$row["density"] .'</td>
                        <td> '.$row["finished"] .'</td>
                        <td> '.$row["date"] .'</td>
                        <td>
                            <button class="btn btn-default" type="reset" style="vertical-align:left; float: center">
                                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                                Cancel
                            </button>
                        </td>
                        </tr>';
            } 
        ?>
            </tbody>
            </div>
        </table>
    </body>
</html>
<?php
    
?>