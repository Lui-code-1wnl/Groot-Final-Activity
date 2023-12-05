<?php
    require('admin/php/db.php');
    include "admin/php/dataclasses.php";
    session_start();

    if (isset($_POST['userID'])){
        $username=$_POST['userID'];
        $password=$_POST['password'];
        $st= $db->prepare("");
        $st->bind_param('ss', $username, $password);
        $st->execute();
        $result= $st-> get_result();

        if($result-> num_rows !=0){
            $_SESSION['userID'] = $username;
        }

        $st->close();
        $_SESSION[''] = new ;
    }
    header('Location: index.php');
    ?>