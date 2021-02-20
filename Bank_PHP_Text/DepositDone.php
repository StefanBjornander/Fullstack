<?php
  function deposit_done($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    $amount = $_POST["amount"];
    
    $customer_query = "insert into history(account_number, amount) " .
                      "values($account_number, $amount)";
    $customer_result = $connection->query($customer_query);
    if (!$customer_result) die("Fatal Error");
    $customer_number = $connection->insert_id;

    echo <<< _END
    Account number $account_number, owned by $customer_name (customer number
    $customer_number), has been deposited with $amount kr.
    <hr>
_END;
  }
?>
