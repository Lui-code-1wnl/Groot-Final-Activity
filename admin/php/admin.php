<body>
<?php
        include("includes/db.php");
        include("includes/banner.html");
        echo "<a href = 'adduser.php'><input type = ' button ' class='btn1' name= 'update-btn' value= 'Add new user'/></a>
        <br>
        <br>
        
        $query ="";

        $stmt = $db->stmt_init();
        $stmt-> prepare($query);
        $stmt-> execute();
        $stmt-> bind_result();

        include("includes/dataclasses.php");

        $=[];

        while ($stmt->fetch()) {
                
        }
        $stmt->close();

        