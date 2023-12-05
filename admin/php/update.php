<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF'>
        <title> OGRAA </title>
        <link rel='stylesheet1' href=''>
    </head>

    <body>
<?php
// not sure if all of this will work
    include("includes/db.php");
    include("includes/banner.html");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPassword = $_POST["new_password"];

        $query = "UPDATE users SET password = ? WHERE userID = ?";
        $stmt = mysqli_stmt_init($db);
        
        if (mysqli_stmt_prepare($stmt, $query)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . mysqli_error($db);
        }
    }

    $id = $_GET['id'];
    $query = "SELECT password FROM users WHERE userID = ?";
    $stmt = mysqli_stmt_init($db);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $currentPassword);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    ?>
    <!-- // <form method="post" action="">
    //     <label for="new_password">New Password:</label>
    //     <input type="password" name="new_password" required>
    //     <input type="submit" value="Update Password">
    // </form>
     <?php
// } else {
//     echo "Error retrieving current password: " . mysqli_error($db);
// }

// mysqli_close($db);
?> -->


        