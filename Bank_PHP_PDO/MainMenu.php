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

    <h1>Bank PDO</h1>

    <table border>
      <tr><td colspan="3">
        <form method="post" action="Bank.php">
          <input type="hidden" name="state" value="add_customer">
          <input type="submit" class="button" value="Add Customer">
        </form>    
      </td></tr>
_END;

    $rows = $connection->query("SELECT * FROM customer");
    if (!$rows) die($connection->errorInfo()[2]);

    foreach ($rows as $row) {
      $customer_number = htmlspecialchars($row["customer_number"]);
      $customer_name = htmlspecialchars($row["customer_name"]);

      echo <<< _END
        <tr><td><b>$customer_number</b></td><td colspan="2"><b>$customer_name</b></td>

        <td class="column2">
          <form method="post" action="Bank.php">
            <input type="hidden" name="state" value="edit_customer">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Edit">              
          </form>
        </td>

        <td class="column2">
          <form method="post" action="Bank.php"
                onsubmit="return confirm('Are you sure you want to remove customer $customer_name?')">
            <input type="hidden" name="state" value="customer_removed">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Remove">
          </form>
        </td>

        <td colspan="2">
          <form method="post" action="Bank.php">
            <input type="hidden" name="state" value="account_added">
            <input type="hidden" name="customer_name" value="$customer_name">
            <input type="hidden" name="customer_number" value="$customer_number">
            <input type="submit" class="button" value="Add Account">
          </form>
        </td></tr>
_END;
        
      $account_query = "SELECT * FROM account WHERE customer_number = :customer_number";
      $account_statement = $connection->prepare($account_query);
      $account_result = $account_statement->execute(["customer_number" => $customer_number]);
      if (!$account_result) die($connection->errorInfo()[2]);
      $account_rows = $account_statement->fetchAll();
        
      foreach ($account_rows as $account_row) {
        $account_number = htmlspecialchars($account_row["account_number"]);
        echo "<tr><td></td><td>$account_number</td>";

        $balance_query = "SELECT SUM(amount) FROM history WHERE account_number = :account_number";
        $balance_statement = $connection->prepare($balance_query);
        $balance_result = $balance_statement->execute(["account_number" => $account_number]);
        if (!$balance_result) die($connection->errorInfo()[2]);

        $balance_rows = $balance_statement->fetchAll();
        $balance = htmlspecialchars($balance_rows[0]["SUM(amount)"]);
        echo "<td>" . (($balance != "") ? $balance : "0") . "</td>";

        echo <<< _END
          <td>
            <form method="post" action="Bank.php">
              <input type="hidden" name="state" value="deposit">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Deposit">
            </form>
          </td>

          <td>
            <form method="post" action="Bank.php">
              <input type="hidden" name="state" value="withdraw">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Withdraw">
            </form>
          </td>

          <td class="column1">
            <form method="post" action="Bank.php">
              <input type="hidden" name="state" value="view_account">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="View">
            </form>
          </td>

          <td class="column1">
            <form method="post" action="Bank.php"
                  onsubmit="return confirm('Are you sure you want to remove account number $account_number, owned by $customer_name (customer number $customer_number)?')">
              <input type="hidden" name="state" value="account_removed">
              <input type="hidden" name="customer_number" value="$customer_number">
              <input type="hidden" name="customer_name" value="$customer_name">
              <input type="hidden" name="account_number" value="$account_number">
              <input type="submit" class="button" value="Remove">
            </form>
          </td></tr>
_END;
      }
    }

    echo "</table>";
  }
?>
