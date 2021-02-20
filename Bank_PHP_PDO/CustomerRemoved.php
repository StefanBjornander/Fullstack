<?php
  function customer_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $account_query = "SELECT COUNT(*) FROM account WHERE customer_number = :customer_number";
    $account_statement = $connection->prepare($account_query);
    $account_result = $account_statement->execute(["customer_number" => $customer_number]);
    if (!$account_result) die($connection->errorInfo()[2]);
    $account_rows = $account_statement->fetchAll();
    $number_of_accounts = htmlspecialchars($account_rows[0]["COUNT(*)"]);

    if ($number_of_accounts == 0) {
      $customer_query = "DELETE FROM customer WHERE customer_number = :customer_number";
      $customer_statement = $connection->prepare($customer_query);
      $customer_result = $customer_statement->execute(["customer_number" => $customer_number]);
      if (!$customer_result) die($connection->errorInfo()[2]);
      echo "Customer $customer_name (customer number $customer_number) has been removed.<hr>";
    }
    else {
      echo "<i>Customer $customer_name (customer number $customer_number) cannot be removed since they own $number_of_accounts accounts.</i><hr>";
    }
  }
?>
