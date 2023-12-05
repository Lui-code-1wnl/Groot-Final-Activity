<?php // not sure if this is needed
    session_start();
    session_unset();
    session_destroy();

    header('Location: index.php');
?>
