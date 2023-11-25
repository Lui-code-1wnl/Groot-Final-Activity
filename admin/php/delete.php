<?php
    include("includes/db.php");
    $id = $_GET['id'];
    $query = "DELETE FROM users where userID ='$id'";
    if($db->query($query)=== TRUE){
        header('Location: admin.php');
    }
?>