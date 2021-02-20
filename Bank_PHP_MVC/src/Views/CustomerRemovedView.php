<?php
  namespace Bank\Views;
  
  class CustomerRemovedView {
    static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      $numberOfAccounts = $properties['numberOfAccounts'];

      echo "<h1>Customer Removed</h1>";

      if ($numberOfAccounts == 0) {
        echo "<p>Customer $customerName with number $customerNumber has been removed.</p>";
      }
      else {
        echo "<p>Customer $customerName with number $customerNumber " .
             "cannot be removed since they own $numberOfAccounts accounts.</p>";
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