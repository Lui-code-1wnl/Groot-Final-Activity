<?php

    if (isset($_GET['search'])) {
        $search = '%' . htmlspecialchars($_GET['search'] . '%');
        
    //query to retrieve the document with the matching title
    $stmt = $conn->prepare("SELECT * FROM request WHERE requestID LIKE ? OR documentTitle LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();

    $result = $stmt->get_result();

    // Display
    echo "<table border='1'>";
    if ($result->num_rows > 0) {
        echo "<tr>";
        echo '<th style="color: #073066;">Request ID</th>';
        echo '<th style="color: #073066;">Document Title</th>';
        echo '<th style="color: #073066;">Date Submitted</th>';
        echo '<th style="color: #073066;">Overall Status</th>';
        echo "</tr>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo '<td style="color: #073066;">' . $row['requestID'] . '</td>';
            echo '<td style="color: #073066;">' . $row['documentTitle'] . '</td>';
            echo '<td style="color: #073066;">' . $row['dateSubmitted'] . '</td>';
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo '<div style="color: #073066; font-weight: bold;">No such document exists</div>';
        }
        
    }

?>
