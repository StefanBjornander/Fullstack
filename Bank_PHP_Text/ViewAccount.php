 <?php
  function view_account($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];

    $history_query = "select * from history where account_number = $account_number";
    $history_result = $connection->query($history_query);
    if (!$history_result) die("Fatal Error");
    $history_size = $history_result->num_rows;
    
    if ($history_size > 0) {
      echo <<< _END
        The history of account number $account_number, owned by $customer_name
        (customer number $customer_number):<p>
            
        <table border>
          <tr><th>Time</th><th>Amount</th></tr>
_END;

      foreach ($history_result->fetch_all(MYSQLI_ASSOC) as $history_row) {
        $history_time = htmlspecialchars($history_row["time"]);
        $history_amount = htmlspecialchars($history_row["amount"]);
        echo "<tr><td>$history_time</td><td>$history_amount</td></tr>";
      }
    
      $account_query = "select sum(amount) from history where account_number = $account_number";
      $account_result = $connection->query($account_query);
      if (!$account_result) die("Fatal Error");
      $account_row = $account_result->fetch_array(MYSQLI_NUM);            
      $account_saldo = htmlspecialchars($account_row[0]);

      echo <<< _END
          <tr><td>Current saldo</td><td>$account_saldo</td></tr>
        </table>
        <hr>
_END;

      $account_result->close();
    }
    else {
      echo "Account number $account_number, owned by $customer_name " .
           "(customer number $customer_number), has no history.<hr>";
    }
    
    $history_result->close();
  }
?>
