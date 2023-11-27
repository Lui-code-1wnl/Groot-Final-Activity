<?php
    require('admin/php/db.php');
    include "admin/php/dataclasses.php";
    session_start();

    if (isset($_POST['userName'])){
        $username=$_POST['userName'];
        $password=$_POST['password'];
        $st= $db->prepare("");
        $st->bind_param('ss', $username, $password);
        $st->execute();
        $result= $st-> get_result();

        if($result-> num_rows !=0){
            $_SESSION['userName'] = $username;
        }

        $st->close();
        $_SESSION[''] = new ;
    }
    header('Location: index.php');
    ?>