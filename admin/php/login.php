<?php
    require('admin/php/db.php');
    include "admin/php/dataclasses.php";
    session_start();

    if (isset($_POST['username'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $st= $db->prepare("SELECT * FROM user WHERE username = ? and password ?");
        $st->bind_param('ss', $username, $password);
        $st->execute();
        $result= $st-> get_result();

        if($result-> num_rows !=0){
            $_SESSION['username'] = $username;
        }

        $st->close();
        $_SESSION['user'] = new User();
    }
    header('Location: index.php');
    ?>