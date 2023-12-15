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
                <li><a href="admin.php">HOME</a></li>
                <li><a href="listofusers.php">USERS</a></li>
                <li><a href="listoflogs.php">LOGS</a></li>
                <div id="admin-display">ADMIN</div>
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
            <h1>Search for Logs</h1>
            <div class="form">
                <div class="row">
                    <div class="input-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                        <input id="requestid" type="text" name="requestid" placeholder="Please Enter Request ID or DocumentTitle" required>
                        <input type="submit" name="submit" value="Search">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="table">
    <br>
    </div>    
    </div>
<?php


ob_start();

 if (isset($_GET['search'])){
    $_SESSION['search_term'] = htmlspecialchars($_GET['search']);
}
if (empty($_GET['search']) && isset($_SESSION['search_term'])){
   unset($_SESSION['search_term']); 
}
    echo '<script>';
    echo 'if (performance.navigation.type == 1) {';
    echo '    window.location.href = "listoflogs.php";'; // Redirect to the same page without search parameters
    echo '}';
    echo '</script>';
    

    if (isset($_SESSION['search_term'])) {
        include 'logssearch.php';
    } else  {
    // Check if there are logs
    if ($result->num_rows > 0) {
        // Display request table
        echo '<div class="row">';
        echo '<table class="transparent-table smaller-table" border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="color: #fff;">Request ID</th>';
        echo '<th style="color: #fff;">Document Title</th>';
        echo '<th style="color: #fff;">Date Submitted</th>';
        echo '<th style="color: #fff;">Overall Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through the result set
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="color: #fff;">' . $row['requestID'] . '</td>';
            echo '<td style="color: #fff;">' . $row['documentTitle'] . '</td>';
            echo '<td style="color: #fff;">' . $row['dateSubmitted'] . '</td>';
            echo '<td style="color: #fff;">' . $row['overallStatus'] . '</td>';
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
    }
    ob_end_flush();
    ?>

</body>
</html>
