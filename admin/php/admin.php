<body>
<?php
        include("includes/db.php");
        include("includes/banner.html");
        echo "<a href = 
        
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

        