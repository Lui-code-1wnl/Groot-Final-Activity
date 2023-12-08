<?php
    include("admin/php/db.php");
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE userID ='$id'";
    if($db->query($query)=== TRUE){
        header('Location: admin.php');
    }
?>