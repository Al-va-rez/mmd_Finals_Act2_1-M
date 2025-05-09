<?php
    session_start();

    $user = "root";
    $password = "";

    $dbname = "mmd_one_to_many";
    $host = "localhost";

    $dsn = "mysql:host={$host};dbname={$dbname}";

    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET time_zone = '+08:00';");
?>