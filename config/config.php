<?php

    try {

        define("HOST", "localhost");

        define("DBNAME", "forum");

        define("USER", "root");

        define("PASSWORD", "");

        $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME . "", USER, PASSWORD);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // if ($conn == true) echo "db connection is a success";

        // else echo "error";

    } catch (PDOException $exception) {

        echo $exception->getMessage();
    }

?>
