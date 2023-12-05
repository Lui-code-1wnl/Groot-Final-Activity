<?php
    include("admin/php/db.php");
    include("includes/banner.html");
    include("includes/adduser.html");

    if(isset($_POST['add'])){
        $id= $_POST["userID"];
        $rol= $_POST['password'];
        $firstN= $_POST["firstName"];
        $lastN= $_POST["lastName"];

        $stmt->execute();
        $stmt->close();
            header('Location: admin.php');

        }
    

    ?>