<?php
  function customer_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $account_statement = $connection->prepare("select count(*) from account where customer_number = ?");
    $account_statement->bind_param("i", $customer_number);
    $account_statement->execute();
    $account_result = $account_statement->get_result();
    if (!$account_result) die("Fatal Error");
    $account_row = $account_result->fetch_array(MYSQLI_NUM);
    $number_of_accounts = htmlspecialchars($account_row[0]);

    if ($number_of_accounts == 0) {
      $customer_statement = $connection->prepare("delete from customer where customer_number = ?");
      $customer_statement->bind_param("i", $customer_number);
      $customer_statement->execute();
      if (!$customer_statement) die("Fatal Error");
      echo "Customer $customer_name (customer number $customer_number) has been removed.<hr>";
    }
    else {
      echo "<i>Customer $customer_name (customer number $customer_number) cannot be removed since they own $number_of_accounts accounts.</i><hr>";
    }
  }
?>
