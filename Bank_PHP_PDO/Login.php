<?php
  function login() {
    $hostname = "localhost";
    $database = "bank_pdo";
    $username = "root";
    $password = "";
    $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    if (!$connection) die($connection->errorInfo()[2]);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $connection;
  }
?>
