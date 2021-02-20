<?php
  function login() {
    $hostname = "localhost";
    $database = "bank_placeholders";
    $username = "root";
    $password = "";
    $connection = new mysqli($hostname, $username, $password, $database);
    if ($connection->connect_error) die("Fatal Error");
    return $connection;
  }
?>
