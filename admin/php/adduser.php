<?php
    include("includes/db.php");
    include("includes/banner.html");
    include("includes/adduser.html");

    if(isset($_POST['add'])){
        $id= $_POST["userID"];
        $cat= $_POST['role'];
        $desc= $_POST["description"];
        $file_size = $_FILES['file']['size'];
        $file = file_get_contents($_FILES['file']['tmp_name']);

        if($file_size > 655335) {
            echo "<div class='err'>ERROR: The file that you have attached is larger than 65KB.</div>";
        }else {

        }
        
    }