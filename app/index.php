<!DOCTYPE html>

<?php
	require("includes/config.php");
    include_once "includes/header.php";
?>

<script type="text/javascript">
    // $(document).ready(function(){
    //     $('#submit').click(function(){
    //         $('row').css("filter","blur(5px)");
    //         $('#loader').removeAttr("hidden");
    //     });
    function calc_lattice() {
        if ($('#x').val() === "" && $('#y').val() === "" && $('#z').val() === "") {

        } else {
            $('#loader').removeAttr("hidden");
            $('row').css("filter","blur(5px)");
        }

        
        // $.ajax({
        //     type: 'POST',
        //     url:'mesh_check.php',
        //     dataType: 'json',
        //     data: {
        //         job_id: $('#id').val(), 
        //         element_size: $('#sel1').val(),
        //         max_element_size: $('#maxElementSize').val(),
        //         min_element_size: $('#minElementSize').val()
        //     },
        //     success: function (data){
        //         $('#animation').attr("hidden", "hidden");
        //         $('.row').css("filter","blur(0px)");
        //         if (data.conversion === "success") {
        //             $('#submit').removeAttr("hidden");
        //             alert("Succesfully meshed your model.");
        //             displayMesh();
        //         } else {
        //             alert("Sorry, this file cannot be meshed due to unconnected nodes. Please upload another file.")
        //         }
        //     }
        // });
	}
            // $.ajax({
            //     type: "POST",
            //     url: "generate_lattice.php",
            //     dataType: 'json',
            //     data: {
            //         shape: $('#shape').val(), 
            //         d_x: $('#x').val(),
            //         d_y: $('#y').val(),
            //         d_z: $('#z').val()
            //     }
            // });
</script>  

<html>
<body>
    <row>
        <div class ="login">  
            <form action="index.php" method="post" enctype="multipart/form-data"> 
                <h1>Lattice Generator</h1>
                <h5>Shape:</h5>
                <select name="element_size" class="form-control" id="shape" required>
                    <option value="45" selected>45 degrees</option>
                    <option value="90">90 degrees</option>
                </select>
                <h5>Dimension:</h5>
                <div class="row">
                    <div class="col-md-4"><input id = "x" type="number" min="1" step="1" placeholder="x" required/></div>
                    <div class="col-md-4"><input id = "y" type="number" min="1" step="1" placeholder="y"required/></div>
                    <div class="col-md-4"><input id = "z" type="number" min="1" step="1" placeholder="z" required/></div>
                </div>
                <h5> </h5>
                <input type="submit" class="btn btn-block btn-large" value="Generate" id="submit" onclick="calc_lattice();">
            </form>
        </div> 
    </row>
    <div id='loader' hidden="true"</div> 
</body>
</html>

<?php
    if (!empty($_POST)) {
        $x = $_POST['x'];
        $y = $_POST['y'];
        $z = $_POST['z'];
        $call_python = $py_path." py/lg_app.py 2>&1".$job_id." ".$x." ".$y." ".$z;
        $result = shell_exec($call_python);
    }
?>