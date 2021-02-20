<?php
  function customer_added($connection) {
    $customer_name = $_POST["customer_name"];
    
    $customer_query = "insert into customer(customer_name) values('$customer_name')";
    $customer_result = $connection->query($customer_query);
    if (!$customer_result) die("Fatal Error");
    $customer_number = $connection->insert_id;

    echo "Customer $customer_name with number $customer_number has been added.</i><hr>";
  }
?>
