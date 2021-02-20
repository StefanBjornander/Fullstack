 <?php
  function account_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    
    $balance_query = "SELECT SUM(amount) FROM history WHERE account_number = :account_number";
    $balance_statement = $connection->prepare($balance_query);
    $balance_statement->execute(["account_number" => $account_number]);
    if (!$balance_statement) die($connection->errorInfo()[2]);
    $balance_rows = $balance_statement->fetchAll();
    $account_balance = htmlspecialchars($balance_rows[0]["SUM(amount)"]);
    
    if (($account_balance == "") || ($account_balance == 0)) {
      if ($account_balance == 0) {
        $history_query = "DELETE FROM history WHERE account_number = :account_number";
        $history_statement = $connection->prepare($history_query);
        $history_statement->execute(["account_number" => $account_number]);
        if (!$history_statement) die($connection->errorInfo()[2]);
      }

      $account_query = "DELETE FROM account WHERE account_number = :account_number";
      $account_statement = $connection->prepare($account_query);
      $account_statement->execute(["account_number" => $account_number]);
      if (!$account_statement) die($connection->errorInfo()[2]);

      echo "Account number $account_number, owned by $customer_name (customer number " .
           "$customer_number), has been removed.<hr>";
    }
    else {
      echo "<i>Account number $account_number, owned by $customer_name (customer " .
           "number $customer_number), cound not be removed since its account balance " .
           "does not equal zero (the account balance equals $account_balance kr).</i><hr>";
    }
  }
?>
