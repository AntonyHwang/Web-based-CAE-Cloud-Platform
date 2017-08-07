<html>
    <head>
        <?php 
            require "includes/config.php"; 
            include_once "includes/header.php";
            if ($_SESSION["logged_in"] != "YES") {
                header("Location: login.php");
            }
        ?>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/table.css">

        <script type="text/javascript">

            $(document).ready(function(){
                var table=$('#jobs_id').DataTable( {
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true
                });
            });

            function deleteJob(name, id) {

                if (confirm("Are you sure you want to delete this job?")) {
                    $.ajax({
                        type: 'POST',
                        url:'delete.php',
                        data: {job_id: name},
                        success: function (data){
                            window.location.reload();
                            //$("#" + id).remove();
                        }
                    });
                    
                }
            }
        </script>


    </head>
    <body>
        <table id="jobs_id" class="table hover">                     
            <thead>
                <tr style="color:white;">
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
            $select_jobs_sql = "SELECT * FROM job WHERE id_user = ".$_SESSION["id"]." AND hidden=0";
            $get_jobs = $dbh->query($select_jobs_sql); 
            $count = 0;
            // output data of each row
            while($row = $get_jobs->fetch()) {
                $count++;
                echo '<tr style="color:white;" id="'.$count.'">
                        <td>'.$count.'</td>
                        <td> 
                            <a href="/results.php?job_id='.$row["job_id"].'"><font color="white">' . $row["job_id"] .'</font></a>
                        </td>
                        <td>
                            <a href="stp_uploads/'.$row["job_id"].'.step" download><font color="white">'. $row["stp_filename"] .'</font></a>
                        </td>
                        <td> '.$row["material_name"] .'</td>
                        <td> '.$row["element_size"] .'</td>
                        <td> '.$row["youngs_mod"] .'</td>
                        <td> '.$row["poissons_ratio"] .'</td>
                        <td> '.$row["density"] .'</td>
                        <td> '.$row["finished"] .'</td>
                        <td> '.$row["date"] .'</td>
                        <td>
                            <button class="btn btn-default" type="reset" id="'.$count.'" name="'.$row["job_id"].'" onclick="deleteJob(this.name, this.id);" style="vertical-align:left; float: center">
                                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                                Cancel
                            </button>
                        </td>
                    </tr>';
                
            } 
        ?>
            </tbody>
        </table>
    </body>
</html>
<?php
    
?>