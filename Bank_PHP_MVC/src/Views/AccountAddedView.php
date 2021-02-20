<?php
  namespace Bank\Views;
  
  class AccountAddedView {
    static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      $accountNumber = $properties['accountNumber'];
      
echo <<< __HTML
      <h1>Account Added</h1>

      <p>Account number $accountNumber, owned by $customerName
         with number $customerNumber, has been added.</p>

      <form method='post' action='/'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }