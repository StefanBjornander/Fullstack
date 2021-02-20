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

    <h1>Bank Placeholders</h1>

    <table border>
      <tr><td colspan="3">
        <form method="post" action="Index.php">
          <input type="hidden" name="state" value="add_customer">
          <input type="submit" class="button" value="Add Customer">
        </form>    
      </td></tr>
_END;

    $customer_statement = $connection->prepare("select * from customer");
    $customer_statement->execute();
    $customer_result = $customer_statement->get_result();
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
        
      $account_statement = $connection->prepare("select * from account where customer_number = ?");
      $account_statement->bind_param("i", $customer_number);
      $account_statement->execute();
      $account_result = $account_statement->get_result();
      if (!$account_result) die("Fatal Error");
        
      foreach ($account_result->fetch_all(MYSQLI_ASSOC) as $account_row) {
        $account_number = htmlspecialchars($account_row["account_number"]);
        echo "<tr><td></td><td>$account_number</td>";

        $balance_statement = $connection->prepare("select sum(amount) from history where account_number = ?");
        $balance_statement->bind_param("i", $account_number);
        $balance_statement->execute();
        $balance_result = $balance_statement->get_result();
        if (!$balance_result) die("Fatal Error");

        $balance_row = $balance_result->fetch_array(MYSQLI_NUM);            
        $balance = htmlspecialchars($balance_row[0]);
        echo "<td>" . (($balance != "") ? $balance : "0") . "</td>";

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

        $balance_result->close();
      }

      $account_statement->close();
    }

    echo "</table>";
    $customer_result->close();
  }
?>
