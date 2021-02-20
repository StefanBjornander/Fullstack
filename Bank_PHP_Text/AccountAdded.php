<?php
  function account_added($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $customer_query = "insert into account(customer_number) values($customer_number)";
    $customer_result = $connection->query($customer_query);
    if (!$customer_result) die("Fatal Error");
    $account_number = $connection->insert_id;

    echo "Account number $account_number, owned by $customer_name (customer number" .
         "$customer_number), has been added.<hr>";
  }
?>
