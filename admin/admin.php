<?php
include("admin/php/db.php");

// query
$query = "SELECT username, firstName, lastName, userRole, status FROM user";
$result = $conn->query($query);

// result set condition
if ($result->num_rows > 0) {
    // table header
    echo "<table border='1'>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Role</th>
                <th>Status</th>
            </tr>";

    // row data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['username'] . "</td>
                <td>" . $row['firstName'] . "</td>
                <td>" . $row['lastName'] . "</td>
                <td>" . $row['userRole'] . "</td>
                <td>" . $row['status'] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No users found";
}

$conn->close();
?>
