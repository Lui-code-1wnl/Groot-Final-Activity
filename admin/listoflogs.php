<?php
include "db.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirect to login page or home page
    exit();
    
}
$db = new DB();
$conn = $db->getConnection();
$query = "SELECT * FROM request";
$result = $conn->query($query);
?>

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
                <li><a href="index.php">HOME</a></li>
                <li><a href="listofusers.php">USERS</a></li>
                <li><a href="listoflogs.php">LOGS</a></li>
                <li><a href="admin.php">ADMIN</a></li>
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

    <?php
    // Check if there are logs
    if ($result->num_rows > 0) {
        // Display request table
        echo '<div class="row">';
        echo '<table class="transparent-table smaller-table" border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="color: #073066;">Request ID</th>';
        echo '<th style="color: #073066;">User ID</th>';
        echo '<th style="color: #073066;">Document Title</th>';
        echo '<th style="color: #073066;">Date Submitted</th>';
        echo '<th style="color: #073066;">Overall Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through the result set
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="color: #073066;">' . $row['requestID'] . '</td>';
            echo '<td style="color: #073066;">' . $row['userID'] . '</td>';
            echo '<td style="color: #073066;">' . $row['documentTitle'] . '</td>';
            echo '<td style="color: #073066;">' . $row['dateSubmitted'] . '</td>';
            echo '<td style="color: #073066;">' . $row['overallStatus'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
            echo 'No logs found.';
        }
        $result->close();
      $conn->close();
    
    ?>
            </div>
        </form>
    </div>
</div>
</body>
</html>
