<?php // not sure if this is needed
    session_start();
    if(!isset($_SESSION['userID'])){
        header('Location: index.php');
    }
    ?>