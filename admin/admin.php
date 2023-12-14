<?php
include "db.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="css_admin/admin-banner.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png">  <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div id="content-holder">
    <div id="banner">
        <div id="title">
            <img id="slu" src="css_admin/imgs/slu-logo.png" alt="slu-logo">
            <div id="title-header">
                <h1>Saint Louis University</h1>
                <h2>Office of Global Relations and Alumni Affairs</h2>
            </div>
            <img id="ograa" src="css_admin/imgs/ograa.png" alt="ograa-logo">
        </div>
        <div id="ograa-logo">
        </div>
    </div>
</div>
<div id="home"> <!-- Landing Page -->
    <div id="main">
        <h1>Welcome ADMIN!</h1>
        <p>A website that will help you track documents!</p>
        <div class="button">
            <a class="continueButton" href="listofusers.php"><b>Continue</b></a>
        </div>
    </div>
</div>

</body>
</html>
