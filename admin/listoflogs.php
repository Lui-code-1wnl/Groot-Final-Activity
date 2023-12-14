<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>OGRAA</title>
    <link rel="stylesheet" href="css_admin/listoflogs.css"> <!-- CSS for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png"> <!-- Favicon -->
    <script src=""></script> <!-- JS for index -->
</head>

<body>
<div id="navbar"> <!-- Navigation -->
    <div id="navigation">
        <div class="logo-container">
            <div id="logo-title">
                <img id="unique-logo" src="../assets/script/public/images/slu-logo.png" alt="Logo">
                <h1><a href="clients/welcome-page.html">Saint Louis University</a></h1>
            </div>
        </div>
        <ul id="navigation-links">
            <li><a href="#home">HOME</a></li>
            <li><a href="#users">USERS</a></li>
            <li><a href="#logs">LOGS</a></li>
            <li><a href="#admin">ADMIN</a></li>
        </ul>
        <div id="logout-container">
            <form id="logout-form" action="logout.php" method="post">
                <button id="logout-button" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</div>
<div id="title-container">
    <h2 id="title">LIST OF LOGS</h2>
</div>
<div class="container">
    <div class="blue-box">
        <form action="" method="post">
            <h1>Search for Logs</h1>
            <div class="form">
                <div class="row">
                    <div class="input-container">
                        <input id="username" type="text" name="username" placeholder="Enter username" required>
                        <button id="search-button" type="submit" name="add-button">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
