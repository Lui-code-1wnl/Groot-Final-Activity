<?php
    include("");
    $id = $_GET['id'];
    $query = "DELETE FROM users where userId ='$id'";
    if($db->query($query)=== TRUE){
        header('');
    }
?>