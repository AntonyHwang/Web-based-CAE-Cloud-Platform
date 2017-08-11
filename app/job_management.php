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
        <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/table.css">

        <script type="text/javascript">

            $(document).ready(function(){
                var table=$('#jobs_id').DataTable( {
                    "order": [[ 1, "desc" ]],
                    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    stateSave: true,
                    responsive: true,
					dom: '<"wrapper"Blfrtip>',
					buttons: [
						{
							text: '<font color="black">Refresh</font>',
							action: function ( e, dt, node, config ) {
								location.reload();
							},
							className: "btn btn-secondary"
						}
					]
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
        <table id="jobs_id" class="table ">                     
            <thead>
                <tr style="color:white;">
                    <th>#</th>
                    <th>Job ID</th>
                    <th>File</th>
                    <th>Material</th>
                    <th>Mesh Scaling Factor</th>
                    <th>Max Element Size</th>
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
                $picture;
                $text;
                $pointer_event;
                if ($row["finished"] == 0) {
                    $picture = "css/buttons/red.png";
                    $text = "   Still Computing";
                    $pointer_event = "none";
                } else {
                    $picture = "css/buttons/green.png";
                    $text = "   Finished";
                    $pointer_event = "auto";
                }
                echo '<tr style="color:white;" id="'.$count.'">
                        <td>'.$count.'</td>
                        <td> 
                            <a href="results.php?job_id='.$row["job_id"].'" style="pointer-events:'.$pointer_event.'"><font color="white">' . $row["job_id"] .'</font></a>
                        </td>
                        <td>
                                <a href="view_x3d.php?job_id='.$row["job_id"].'"><font color="white">'. $row["stp_filename"] .'</font></a>
                        </td>
                        <td> 
                            <div id="bbox" class="dropdown">
                                <span>'.$row["material_name"].'</span>
                                <div id="material_props" style="text-align:left; color:black; padding-left: 5px;" class="dropdown-menu properties" aria-labelledby="dropdownMenu2">
                                    <b class="dropdown-item">Poissons: '.$row["poissons_ratio"].'</b><br>
                                    <b class="dropdown-item">Density: '.$row["density"].'</b><br>
                                    <b class="dropdown-item">Youngs Mod: '.$row["youngs_mod"].'</b><br>
                                </div>
                            </div>


                            
                        </td>
                        <td> '.$row["element_size"] .'</td>
                        <td> '.$row["max_element_size"] .'</td>
                        <td> 
                            <h5><img src="'.$picture.'" style="width:10px; height:10px;">'.$text.'</h5>
                        </td>
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