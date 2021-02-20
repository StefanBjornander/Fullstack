<?php
  function customer_edited($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $customer_statement = $connection->prepare("update customer set customer_name = ?" .
                                               " where customer_number = ?");
    $customer_statement->bind_param("si", $customer_name, $customer_number);
    $customer_statement->execute();
    if (!$customer_statement) die("Fatal Error");
    
    echo "Customer $customer_name with number $customer_number has been edited.<hr>";
  }
?>
