<?php
  function deposit($connection) {   
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
    $account_number = $_POST["account_number"];
      
    echo <<< _END
      Deposition on account number $account_number, owned by $customer_name
      (customer number $customer_number).<p>

      <form method="post" action="Bank.php">
        Amount: <input type="text" name="amount" autofocus="autofocus">
        <input type="hidden" name="customer_name" value="$customer_name">
        <input type="hidden" name="customer_number" value="$customer_number">
        <input type="hidden" name="account_number" value="$account_number">
        <input type="hidden" name="state" value="deposit_done">
        <input type="submit" value="Ok">
      </form>
      <hr>
_END;
  }
?>