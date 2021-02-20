<?php
  namespace Bank\Views;

  class EditCustomerView {
    public static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];

echo <<< __HTML
      <h1>Edit Customer</h1>

      <form method='post' action='/customer_edited/$customerNumber/$customerName'>
        Name: <input type='text' name='customerName'
               value='$customerName' autofocus='autofocus'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }