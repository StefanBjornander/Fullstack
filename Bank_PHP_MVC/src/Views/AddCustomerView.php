<?php
  namespace Bank\Views;

  class AddCustomerView {
    public static function render($properties) {
      ob_start();
echo <<< __HTML
      <h1>Add Customer</h1>

      <form method='post' action='/customer_added'>
        Name: <input type='text' name='customerName' autofocus='autofocus'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }