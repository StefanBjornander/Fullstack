<?php
  function account_added($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $account_statement = $connection->prepare("insert into account(customer_number) values(?)");
    $account_statement->bind_param("i", $customer_number);
    $account_statement->execute();
    if (!$account_statement) die("Fatal Error");
    $account_number = $connection->insert_id;

    echo "Account number $account_number, owned by $customer_name (customer number" .
         " $customer_number), has been added.<hr>";
  }
?>
