<?php
    session_start();

    // sets user to 'offline' status
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $updateStatus = $db->prepare("UPDATE user SET status = 'offline' WHERE username = ?");
        $updateStatus->bind_param('s', $username);
        $updateStatus->execute();
        $updateStatus->close();

        $_SESSION = array();
        session_destroy();

        header('Location: login.php');
        exit();
    } else {
        header('Location: login.php');
        exit();
    }
?>
