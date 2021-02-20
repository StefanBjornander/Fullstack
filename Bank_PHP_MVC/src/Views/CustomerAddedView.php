<?php
  namespace Bank\Views;

  class CustomerAddedView {
    public static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      
echo <<< __HTML
      <h1>Customer Added</h1>

      <p>Customer $customerName with number $customerNumber has been added.</p>

      <form method='post' action='/'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }
  
  