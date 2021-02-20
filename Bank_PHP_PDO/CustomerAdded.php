<?php
  function customer_added($connection) {
    $customer_name = $_POST["customer_name"];
    
    $customer_query = "INSERT INTO customer(customer_name) VALUES(:customer_name)";
    $customer_statement = $connection->prepare($customer_query);
    $customer_statement->execute(["customer_name" => $customer_name]);
    if (!$customer_statement) die($connection->errorInfo()[2]);
    $customer_number = $connection->lastInsertId();
    echo "Customer $customer_name with number $customer_number has been added.</i><hr>";
  }
?>
