<?php
  function customer_edited($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $customer_query = "UPDATE customer SET customer_name = :customer_name " .
                      "WHERE customer_number = :customer_number";
    $customer_statement = $connection->prepare($customer_query);
    $customer_parameters = ["customer_name" => $customer_name, "customer_number" => $customer_number];
    $customer_result = $customer_statement->execute($customer_parameters);
    if (!$customer_result) die($connection->errorInfo()[2]);
    
    echo "Customer $customer_name with number $customer_number has been edited.<hr>";
  }
?>
