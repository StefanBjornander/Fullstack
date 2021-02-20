<?php
  function account_added($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $account_query = "INSERT INTO account(customer_number) VALUES(:customer_number)";
    $account_statement = $connection->prepare($account_query);
    $account_statement->execute(["customer_number" => $customer_number]);
    if (!$account_statement) die($connection->errorInfo()[2]);
    $account_number = $connection->lastInsertId();

    echo "Account number $account_number, owned by $customer_name (customer number" .
         " $customer_number), has been added.<hr>";
  }
?>
