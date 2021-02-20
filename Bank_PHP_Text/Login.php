<?php
  function login() {
    $hostname = "localhost";
    $database = "bank_text";
    $username = "root";
    $password = "";
    $connection = new mysqli($hostname, $username, $password, $database);
    return $connection;
  }
?>
