 <?php
  function account_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    
    $balance_statement = $connection->prepare("select sum(amount) from history where account_number = ?");
    $balance_statement->bind_param("i", $account_number);
    $balance_statement->execute();
    $balance_result = $balance_statement->get_result();
    if (!$balance_result) die("Fatal Error");
    $balance_row = $balance_result->fetch_array(MYSQLI_NUM);            
    $account_balance = htmlspecialchars($balance_row[0]);
    
    if (($account_balance == "") || ($account_balance == 0)) {
      if ($account_balance == 0) {
        $history_statement = $connection->prepare("delete from history where account_number = ?");
        $history_statement->bind_param("i", $account_number);
        $history_statement->execute();
        if (!$history_statement) die("Fatal Error");
      }

      $account_statement = $connection->prepare("delete from account where account_number = ?");
      $account_statement->bind_param("i", $account_number);
      $account_statement->execute();
      if (!$account_statement) die("Fatal Error");

      echo "Account number $account_number, owned by $customer_name (customer number " .
           "$customer_number), has been removed.<hr>";
    }
    else {
      echo "<i>Account number $account_number, owned by $customer_name (customer " .
           "number $customer_number), cound not be removed since its account balance " .
           "does not equals zero (the account balance equals $account_balance kr).</i><hr>";
    }

    $balance_result->close();
  }
?>
