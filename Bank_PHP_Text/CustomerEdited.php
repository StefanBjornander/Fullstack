<?php
  function customer_edited($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $customer_query = "update customer set customer_name = '$customer_name'" .
                      " where customer_number = $customer_number";
    $customer_result = $connection->query($customer_query);
    if (!$customer_result) die("Fatal Error");

    echo "Customer $customer_name with number $customer_number has been edited.<hr>";
  }
?>
