<?php
    require 'db.php'; 
    
    $search = $_GET['search'];

    //query to retrieve the users with the matching username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username LIKE ?");
    $search = '%' . $search . '%'; // match any characters
    $stmt->bind_param("s", $search);

    //SQL query and get the result
    $stmt->execute();
    $result = $stmt->get_result();

    // Display
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th></tr>";
    while ($row = $result->fetch_assoc()) {

        echo "ID: " . $row["id"] . " - Username: " . $row["username"] . "<br>";
    }
    echo "</table>";
    // Close the database connection
    $conn->close();
?>
