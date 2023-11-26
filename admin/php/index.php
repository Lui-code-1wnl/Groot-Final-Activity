<?php
    session_start();

    include "includes/header.php";

    if(!isset($_SESSION["theuser"])) {
        include "includes/login_form.html":
    } else {
        include "includes/index.html"
    }
    include 'includes/footer/html'
?>