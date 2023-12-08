<?php
    include("admin/php/db.php");
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE username ='$id'";
    if($db->query($query)=== TRUE){
        header('Location: admin.php');
    }
?>