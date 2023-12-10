<?php
include("db.php");

if (isset($_POST['add-button'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['first-name'];
    $lastname = $_POST['last-name'];

    // check if username is already existing 
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        // insert new user
        $stmt = $conn->prepare("INSERT INTO user (userID, username, password, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $firstname, $lastname);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}
?>
