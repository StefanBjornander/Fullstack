<?php
  function main_menu($connection) {
    echo <<< _END
    <style>
      .column1 {
        width: 20mm;
      }
      .column2 {
        width: 20mm;
      }
      .button {
        width: 100%;
      }
    </style>

    <h1>Bank Text</h1>

    <table border>
      <tr><td colspan="3">
        <form method="post" action="Index.php">
          <input type="hidden" name="state" value="add_customer">
          <input type="submit" class="button" value="Add Customer">
        </form>    
      </td></tr>
_END;

    $customer_query = "select* from customer";
    $customer_result = $connection->query($customer_query);
    if (!$customer_result) die("Fatal Error");

    foreach ($customer_result->fetch_all(MYSQLI_ASSOC) as $customer_row) {
      $customer_number = htmlspecialchars($customer_row["customer_number"]);
      $customer_name = htmlspecialchars($customer_row["customer_name"]);

      echo <<< _END
        <tr><td><b>$customer_number</b></td><td colspan="2"><b>$customer_name</b></td>
              
        <td class="column2">
          <form method="post" action="Index.php">
            <input type="hidden" name="state" value="edit_customer">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Edit">              
          </form>
        </td>

        <td class="column2">
          <form method="post" action="Index.php"
               onsubmit="return confirm('Are you sure you want to remove customer $customer_name?')">
            <input type="hidden" name="state" value="customer_removed">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Remove">
          </form>
        </td>

        <td colspan="2">
          <form method="post" action="Index.php">
            <input type="hidden" name="state" value="account_added">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Add Account">
          </form>
        </td></tr>
_END;
        
      $account_query = "select * from account where customer_number = $customer_number";
      $account_result = $connection->query($account_query);
      if (!$account_result) die("Fatal Error");
          
      foreach ($account_result->fetch_all(MYSQLI_ASSOC) as $account_row) {
        $account_number = htmlspecialchars($account_row["account_number"]);
        echo "<tr><td></td><td>$account_number</td>";

        $saldo_query = "select sum(amount) from history where account_number = $account_number";
        $saldo_result = $connection->query($saldo_query);
        if (!$saldo_result) die("Fatal Error");

        $saldo_row = $saldo_result->fetch_array(MYSQLI_NUM);            
        $saldo = htmlspecialchars($saldo_row[0]);
        echo "<td>" . (($saldo != "") ? $saldo : "0") . "</td>";

        echo <<< _END
          <td>
            <form method="post" action="Index.php">
              <input type="hidden" name="state" value="deposit">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Deposit">
            </form>
          </td>

          <td>
            <form method="post" action="Index.php">
              <input type="hidden" name="state" value="withdraw">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Withdraw">
            </form>
          </td>

          <td class="column1">
            <form method="post" action="Index.php">
              <input type="hidden" name="state" value="view_account">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="View">
            </form>
          </td>

          <td class="column1">
            <form method="post" action="Index.php"
                  onsubmit="return confirm('Are you sure you want to remove account number $account_number, owned by $customer_name (customer number $customer_number)?')">
              <input type="hidden" name="state" value="account_removed">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Remove">
            </form>
          </td></tr>
_END;

        $saldo_result->close();
      }

      $account_result->close();
    }

    echo "</table>";
    $customer_result->close();
  }
?>
