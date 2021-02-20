<?php
  namespace Bank\Views;
  
  class AccountRemovedView {
    static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      $accountNumber = $properties['accountNumber'];
      $accountBalance = $properties['accountBalance'];

      echo "<h1>Account Removed</h1>";

      if ($accountBalance == 0) {
        echo "<p>Account number $accountNumber, owned by $customerName " .
             "with number $customerNumber, has been removed.</p>";
      }
      else {
        echo "<p>Account number $accountNumber, owned by $customerName with customer" .
             "number $customerNumber, cound not be removed since its account balance" .
             "does not equal zero (the account balance equals $accountBalance kr).</p>";
      }

echo <<< __HTML
      <form method='post' action='/'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }