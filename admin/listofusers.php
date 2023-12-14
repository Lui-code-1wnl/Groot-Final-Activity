<?php
require 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
// Create a database connection
$db = new DB();
$conn = $db->getConnection();

// Check if the connection is successful
if ($conn === null) {
    die("Database connection failed.");
}

// Handling the form submission to add a new user
if (isset($_POST['add-button'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $userRole = $_POST['list-of-user'];

    // Validate if the username and first name contain only alphanumeric characters and underscores
    if (!preg_match('/^\w+$/', $username) || !preg_match('/^\w+$/', $firstName)) {
        $_SESSION['error'] = "Invalid username or first name format. Please enter valid values.";
        header('Location: index.php');
        exit();
    }

    // Check if the username already exists
    $stmtCheck = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Username already exists, display error message
        $_SESSION['error'] = "Username already exists.";
    } else {
        // Username is unique, proceed with adding the new user
        $stmtAdd = $conn->prepare("INSERT INTO user (username, password, firstName, lastName, userRole, status) VALUES (?, ?, ?, ?, ?, 'offline')");
        $stmtAdd->bind_param('sssss', $username, $password, $firstName, $lastName, $userRole);

        if ($stmtAdd->execute()) {
            // Display success message
            $_SESSION['success'] = "User added successfully.";
        } else {
            // Display error message
            $_SESSION['error'] = "Error adding user. Please try again.";
        }

        // Close the statement for adding a user
        $stmtAdd->close();
    }

    // Close the statement for checking existing username
    $stmtCheck->close();

    // Redirect to the index.php page
    header('Location: index.php');
    exit();
}
// Fetch user data from the database for displaying the user table
$query = "SELECT * FROM user";
$result = $conn->query($query);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>OGRAA</title>
    <link rel="stylesheet" href="css_admin/listofusers.css"> <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png"> <!-- Favicon -->
    <script src=""></script> <!-- JS for index-->
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
                            <div id="logout-container">
                                  <form id="logout-form" action="logout.php" method="post">
                                        <button id="logout-button" type="submit" name="logout">Logout</button>
                                </form>
                        </ul>
                    </div>
                </div>
            </div>


    <div id="title-container">
        <h2 id="title">LIST OF USERS</h2>
    </div>

    <div class="container">
        <div class="blue-box">
            <form action="" method="post">
                <h1>Create a New Account</h1>
                <div class="form">
                    <div class="row">
                        <div class="input-container">
                            <input id="username" type="text" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="input-container">
                            <input id="password" type="password" name="password" placeholder="Enter Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <button id="add-button" type="submit" name="add-button">+ Add</button>
                    </div>
                    <div class="row">
                        <div class="input-container">
                            <input id="first-name" type="text" name="first-name" placeholder="First Name" required>
                        </div>
                        <div class="input-container">
                            <input id="last-name" type="text" name="last-name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="userlist">
                        <select id="list-of-user" name="list-of-user" required>
                            <option disabled selected value="">Select Type of User</option>
                            <option value="admin">Admin</option>
                            <option value="office">Reviewer</option>
                            <option value="user">Requester</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div id="search-box">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <input type="text" id="search-input" name="search" placeholder="Search">
            <input type="submit" name="submit" value="Search">
        </form>
        </div>
    </div>
    <div class="row" id="button-row">
    <a href="update.php"><button id="update-account-button" type="button">Update an Account</button></a>
    <a href="delete.php"><button id="delete-account-button" type="button">Delete an Account</button></a>
</div>
    </div>

    <?php
    ob_start();
    
    if (isset($_GET['search'])){
        $_SESSION['search_term'] = htmlspecialchars($_GET['search']);
    }
    if (empty($_GET['search']) && isset($_SESSION['search_term'])){
       unset($_SESSION['search_term']); 
       session_destroy();
    }
    echo '<script>';
    echo 'if (performance.navigation.type == 1) {';
    echo '    window.location.href = "listofusers.php";'; // Redirect to the same page without search parameters
    echo '}';
    echo '</script>';
    if (isset($_SESSION['search_term'])) {
        include 'search.php';
    } else {
    // Check if there are users
    if ($result->num_rows > 0) {
        // Display user table
        echo '<div class="row">';
        echo '<table class="transparent-table smaller-table" border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="color: #073066;">Username</th>';
        echo '<th style="color: #073066;">First Name</th>';
        echo '<th style="color: #073066;">Last Name</th>';
        echo '<th style="color: #073066;">User Role</th>';
        echo '<th style="color: #073066;">Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through the result set
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="color: #073066;">' . $row['username'] . '</td>';
            echo '<td style="color: #073066;">' . $row['firstName'] . '</td>';
            echo '<td style="color: #073066;">' . $row['lastName'] . '</td>';
            echo '<td style="color: #073066;">' . $row['userRole'] . '</td>';
            echo '<td style="color: #073066;">' . $row['status'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
            echo 'No users found.';
        }
    
    
        $result->close();
        $conn->close();
    }
    ob_end_flush();
    ?>
</body>

</html>
