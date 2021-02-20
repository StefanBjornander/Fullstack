 <?php
  function account_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    
    $balance_query = "select sum(amount) from history where account_number = $account_number";
    $balance_result = $connection->query($balance_query);
    if (!$balance_result) die("Fatal Error 1");
    $balance_row = $balance_result->fetch_array(MYSQLI_NUM);            
    $account_balance = htmlspecialchars($balance_row[0]);
    
    if (($account_balance == "") || ($account_balance == 0)) {
      if ($account_balance == 0) {
        $history_query = "delete from history where account_number = $account_number";
        $history_result = $connection->query($history_query);
        if (!$history_result) die("Fatal Error 2");
      }

      $account_query = "delete from account where account_number = $account_number";
      $account_result = $connection->query($account_query);
      if (!$account_result) die("Fatal Error 3");

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
