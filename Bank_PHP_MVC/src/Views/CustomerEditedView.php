<?php
  namespace Bank\Views;

  class CustomerEditedView {
    public static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerOldName = $properties['customerOldName'];
      $customerNewName = $properties['customerNewName'];

echo <<< __HTML
      <h1>Customer Edited</h1>

      <p>The name of the customer with number $customerNumber
         has been changed from $customerOldName to $customerNewName.</p>

      <form method='post' action='/'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }
