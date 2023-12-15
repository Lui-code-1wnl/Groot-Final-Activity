<?php
    if (isset($_GET['search'])) {
        $search = '%' . htmlspecialchars($_GET['search'] . '%');
        
    //query to retrieve the users with the matching username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username LIKE ?");
    $search = '%' . $search . '%'; // match any characters
    $stmt->bind_param("s", $search);
    $stmt->execute();

    $result = $stmt->get_result();

    // Display
    echo "<table border='1'>";
    if ($result->num_rows > 0) {
        echo "<tr>";
        echo '<th style="color: #073066;">Username</th>';
        echo '<th style="color: #073066;">First Name</th>';
        echo '<th style="color: #073066;">Last Name</th>';
        echo '<th style="color: #073066;">User Role</th>';
        echo '<th style="color: #073066;">Status</th>';
        echo "</tr>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo '<td style="color: #073066;">' . $row['username'] . '</td>';
            echo '<td style="color: #073066;">' . $row['firstName'] . '</td>';
            echo '<td style="color: #073066;">' . $row['lastName'] . '</td>';
            echo '<td style="color: #073066;">' . $row['userRole'] . '</td>';
            echo '<td style="color: #073066;">' . $row['status'] . '</td>';
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo '<div style="color: #073066; font-weight: bold;">No such user exists</div>';
        
    }
    }
?>