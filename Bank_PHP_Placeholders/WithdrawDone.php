<?php
  function withdraw_done($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    $amount = $_POST["amount"];
    $negative_amount = -$amount;
    
    $customer_statement = $connection->prepare("insert into history(account_number, amount) values(?, ?)");
    $customer_statement->bind_param("id", $account_number, $negative_amount);
    $customer_statement->execute();
    if (!$customer_statement) die("Fatal Error");

    echo <<< _END
    Account number $account_number, owned by $customer_name (customer number
    $customer_number), has been withdrawn with $amount kr.
    <hr>
_END;
  }
?>
