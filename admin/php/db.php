<?php
$host = 'localhost'; // (jdbc:mysql://localhost:3306/groot_final) not sure if need all of this
$dbname = 'groot_final';
$username = 'root';
$password = '';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>