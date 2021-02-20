<?php
  function customer_removed($connection) {
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    
    $account_query = "select count(*) from account where customer_number = $customer_number";
    $account_result = $connection->query($account_query);
    if (!$account_result) die("Fatal Error");
    $account_row = $account_result->fetch_array(MYSQLI_NUM);
    $number_of_accounts = htmlspecialchars($account_row[0]);

    if ($number_of_accounts == 0) {
      $customer_query = "delete from customer where customer_number = $customer_number";
      $customer_result = $connection->query($customer_query);
      if (!$customer_result) die("Fatal Error");
      echo "Customer number $customer_number, owned by $customer_name, has been removed.<hr>";
    }
    else {
      echo "<i>Customer number $customer_number, owned by $customer_name, cannot be removed since they own $number_of_accounts accounts.</i><hr>";
    }
  }
?>
