<?php
  namespace Bank\Views;

  class DepositView {
    public static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      $accountNumber = $properties['accountNumber'];

echo <<< __HTML
      <h1>Deposit</h1>

      <p>Account number $accountNumber, owned by $customerName
         with number $customerNumber.</p>

      <form method='post' action='/deposit_done/$customerNumber/$customerName/$accountNumber'>
        Amount: <input input type='number' step='0.01'
                       name='amount' autofocus='autofocus'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }