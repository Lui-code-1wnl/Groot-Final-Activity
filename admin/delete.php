<?php
include 'db.php';

session_start();

$db = new DB();
$conn = $db->getConnection();
$stmtUsers = $conn->prepare("SELECT username FROM user WHERE userRole <> 'admin'");
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

$userList = [];
while ($row = $resultUsers->fetch_assoc()) {
    $userList[] = $row['username'];
}

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['delete-username'])) {
    $usernameToDelete = $_POST['username'];

    $db = new DB();
    $conn = $db->getConnection();

    // Check if the user exists
    $checkQuery = "SELECT * FROM user WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $usernameToDelete);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows != 0) {
        // User exists, proceed with deletion
        $deleteQuery = "DELETE FROM user WHERE username = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("s", $usernameToDelete);
        $deleteStmt->execute();
        $deleteStmt->close();

        $_SESSION['success'] = "User '$usernameToDelete' has been deleted successfully.";
    } else {
        $_SESSION['error'] = "User '$usernameToDelete' not found.";
    }

    $checkStmt->close();
    header("Location: listofusers.php"); // Redirect back to the user list page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="css_admin/delete-user.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png">  <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
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
                             <div id="admin-display">ADMIN</div> <!-- Replace <li> with <div> or <span> -->
                             <div id="logout-container">
                                 <form id="logout-form" action="logout.php" method="post">
                                     <button id="logout-button" type="submit" name="logout">Logout</button>
                                 </form>
                             </div>
                         </ul>
                    </div>
                </div>
            </div>

    <div id = "input-section">
        <form action='' method="post">

            <h1><pre>Delete User</pre></h1>

            <div class="input-container">
            <label for="username">Select User</label>
            <div class="select-container">
                <select id="username" name="username" required>
                    <?php foreach ($userList as $user) : ?>
                        <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="fa-input"><i class="fas fa-user"></i></span>
            </div>
        </div>
            <br>
            <br>

            <br>
            <br>
            <input id="delete-username-btn" type="submit" name="delete-username" value="Delete">
        </form>
    </div>
</div>
</body>
</html>