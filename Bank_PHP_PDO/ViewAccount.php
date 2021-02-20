 <?php
  function view_account($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];

    $history_query = "SELECT * FROM history WHERE account_number = :account_number";
    $history_statement = $connection->prepare($history_query);
    $history_result = $history_statement->execute(["account_number" => $account_number]);
    if (!$history_result) die($connection->errorInfo()[2]);
    $history_size = $history_statement->rowCount();
    
    if ($history_size > 0) {
      echo <<< _END
        The history of account number $account_number, owned by $customer_name
        (customer number $customer_number):<p>
            
        <table border>
          <tr><th>Time</th><th>Amount</th></tr>
_END;

      $history_rows = $history_statement->fetchAll();
      foreach ($history_rows as $history_row) {
        $time = htmlspecialchars($history_row["time"]);
        $amount = htmlspecialchars($history_row["amount"]);
        echo "<tr><td>$time</td><td>$amount</td></tr>";
      }
    
      $account_query = "SELECT SUM(amount) FROM history WHERE account_number = :account_number";
      $account_statement = $connection->prepare($account_query);
      $account_result = $account_statement->execute(["account_number" => $account_number]);
      if (!$account_result) die($connection->errorInfo()[2]);
      $account_row = $account_statement->fetchAll();
      $account_balance = htmlspecialchars($account_row[0]["SUM(amount)"]);

      echo <<< _END
          <tr><td>Balance</td><td>$account_balance</td></tr>
        </table>
        <hr>
_END;
    }
    else {
      echo "Account number $account_number, owned by $customer_name " .
           "(customer number $customer_number), has no history.<hr>";
    }
  }
?>
