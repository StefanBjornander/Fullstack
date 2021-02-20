<?php
  namespace Bank\Views;

  class ViewAccountView {
    public static function render($properties) {
      ob_start();
      $customerNumber = $properties['customerNumber'];
      $customerName = $properties['customerName'];
      $accountNumber = $properties['accountNumber'];
      $accountEvents = $properties['accountEvents'];
      $accountBalance = $properties['accountBalance'];
      
      echo "<h1>View Account</h1>";

      if (count($accountEvents) > 0) {
echo <<< __HTML
        <p>The history of account number $accountNumber,
           owned by $customerName with number $customerNumber.</p>

        <table border>
          <tr><th>Time</th><th>Amount</th></tr>
__HTML;

          foreach ($accountEvents as $accountEvent) {
            $time = $accountEvent['time'];
            $amount = $accountEvent['amount'];
            
echo <<< __HTML
            <tr>
              <td>$time</td><td>$amount</td>
            </tr>
__HTML;
          }
    
echo <<< __HTML
          <tr>
            <td>Balance</td><td>$accountBalance</td>
          </tr>
        </table>
__HTML;
      }
      else {
echo <<< __HTML
        <p>Account number $accountNumber, owned by $customerName
         with number $customerNumber, has no history.</p>
__HTML;
      }
echo <<< __HTML
      <p/>

      <form method='post' action='/'>
        <input type='submit' autofocus='autofocus' value='Ok'>
      </form>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }