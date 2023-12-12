<?php
    include("includes/db.php");
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE username ='$id'";
    if($db->query($query)=== TRUE){
        header('Location: index.php');
    }
?>