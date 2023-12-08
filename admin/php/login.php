<?php
    require('admin/php/db.php');
    include "admin/php/dataclasses.php";
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashedPassword = md5($password);
    
        $st = $db->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $st->bind_param('ss', $username, $hashedPassword);
        $st->execute();
        $result = $st->get_result();
    
        try {
            if ($result->num_rows != 0) {
                $userData = $result->fetch_assoc();

                // if user is already online
                if ($userData['status'] == 'online') {
                    echo "User is already logged in.";
                } else {
                    $_SESSION['username'] = $username;
                   // $_SESSION['user'] = new User();

                    // Update status to "online"
                    $updateStatus = $db->prepare("UPDATE user SET status = 'online' WHERE username = ?");
                    $updateStatus->bind_param('s', $username);
                    $updateStatus->execute();
                    $updateStatus->close();
                }
            } else {
                echo "Invalid username or password.";
            }
        } finally {
            $st->close();
        }
    }
    header('Location: index.php');
?>
