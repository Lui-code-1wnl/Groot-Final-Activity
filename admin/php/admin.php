<body>
<?php
        include("includes/db.php");
        include("includes/banner.html");
        echo "<a href='adduser.php'><input type='button' class='btn1' name='update-btn' value='Add new user'/></a><br><br>";

        $query ="SELECT * FROM users ORDER BY username";

        $stmt = $db->stmt_init();
        $stmt->prepare($query);
        $stmt->execute();
        $stmt->bind_result($userID, $firstName, $lastName, $password, $userRole, $status);

        include("includes/dataclasses.php");

        $users = [];

        while ($stmt->fetch()) {
               $user = new User($userID, $firstName, $lastName, $password, $userRole, $status);
               $users[] = $user; 
        }
        $stmt->close();

        foreach ($users as $user) {
                $userID = $user->get_userID();
                $username = $user->get_userName();
                $firstName = $user->get_firstName();
                $lastName = $user->get_lastName();
                $password = $user->get_password();
                $userRole = $user->get_userRole();
                $status = $user->get_status();
        }
?>
</body>     


        