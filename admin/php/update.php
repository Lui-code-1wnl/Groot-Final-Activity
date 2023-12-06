<?php
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have the update logic here, modify as needed
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Your update logic goes here...

    // Example: Updating the password
    $query = "UPDATE user SET password = ? WHERE username = ?";
    $stmt = mysqli_stmt_init($db);

    if (mysqli_stmt_prepare($stmt, $query)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);

        if (mysqli_stmt_execute($stmt)) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing update statement: " . mysqli_error($db);
    }
}

// Close the database connection
mysqli_close($db);
?>
