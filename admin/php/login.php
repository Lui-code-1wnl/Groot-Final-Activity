<?php
include("db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // user conditions
    if ($user) {
        // pang debug lang at makita kung nababasa ba yung input
        echo "hatdog na user: $username<br>";
        echo "Entered Password: $password<br>";
        echo "Retrieved from db for user: {$user['password']}<br>";

        if (password_verify($password, $user['password'])) {
            // valid credentials punta siya dito
            header("Location: ../clients/listofusers.html");
            exit();
            // error handlings below
        } else {
            // PROBLEM: dito nadidirect sa condition na ito after input ng credents kahit tama password ni user
            echo "Invalid password";
        }
    } else {
        // this works fine 
        echo "Invalid username";
    }
    $stmt->close();
}
$conn->close();
?>
