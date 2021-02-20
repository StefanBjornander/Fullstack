<?php
  function customer_added($connection) {
    $customer_name = $_POST["customer_name"];
    
    $customer_statement = $connection->prepare("insert into customer(customer_name) values(?)");
    $customer_statement->bind_param("s", $customer_name);
    $customer_statement->execute();
    if (!$customer_statement) die("Fatal Error");
    $customer_number = $connection->insert_id;
    echo "Customer $customer_name with number $customer_number has been added.</i><hr>";
  }
?>
