<?php
  function withdraw_done($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
    $amount = $_POST["amount"];
    $negative_amount = -$amount;
    
    $customer_query = "INSERT INTO history(account_number, amount) " .
                      "VALUES(:account_number, :negative_amount)";
    $customer_statement = $connection->prepare($customer_query);
    $customer_parameters = ["account_number" => $account_number, "negative_amount" => $negative_amount];
    $customer_result = $customer_statement->execute($customer_parameters);
    if (!$customer_result) die($connection->errorInfo()[2]);

    echo <<< _END
    Account number $account_number, owned by $customer_name (customer number
    $customer_number), has been withdrawn with $amount kr.
    <hr>
_END;
  }
?>
