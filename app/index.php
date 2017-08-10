<!DOCTYPE html>

<?php
	require("includes/config.php");
    include_once "includes/header.php";
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("input").click(function(){
            $('row').css("filter","blur(3px)");
            $.ajax({
                type: "POST",
                url: "generate_lattice.php",
                data: { param: text}
                }).done(function( o ) {
                // do something
                });

        });
    });
</script>  

<html>
<body>
    <row>
        <div class ="login">  
            <form action="index.php" method="post" enctype="multipart/form-data"> 
                <h1>Lattice Generator</h1>
                <h5>Shape:</h5>
                <select name="element_size" class="form-control" id="sel1" required>
                    <option value="45" selected>45 degrees</option>
                    <option value="90">90 degrees</option>
                </select>
                <h5>Dimension:</h5>
                <div class="row">
                    <div class="col-md-4"><input type="number" min="1" step="1" placeholder="x" required/></div>
                    <div class="col-md-4"><input type="number" min="1" step="1" placeholder="y"required/></div>
                    <div class="col-md-4"><input type="number" min="1" step="1" placeholder="z" required/></div>
                </div>
                <h5> </h5>
                <input type="submit" class="btn btn-block btn-large" value="Generate" id="submit">
            </form>
        </div> 
    </row>
    <div id="loader" hidden = "true"></div> 
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