<?php
  namespace Bank\Views;

  class MainMenuView {
    public static function render($properties) {
      ob_start();
echo <<< __HTML
        <style>
          .column1 {
            width: 20mm;
          }

          .button {
            width: 100%;
          }
        </style>

        <table border>
          <tr>
            <td colspan='3'>
              <form action='/add_customer' method='get'>
                <input type='submit' class='button' value='Add Customer'>
              </form>  
            </td>
          </tr>
__HTML;
          foreach ($properties['customers'] as $customer) {
            $customerNumber = $customer['customerNumber'];
            $customerName = urldecode($customer['customerName']);
            
echo <<< __HTML
            <tr>
              <td><b>$customerNumber</b></td>
                  <td colspan = '2'><b>$customerName</b></td>

              <td>
                <form method='post'
                      action='/edit_customer/$customerNumber/$customerName'>
                  <input type='submit' class='button' value='Edit'>
                </form>
              </td>

              <td>
                <form method='post'
                      action='/remove_customer/$customerNumber/$customerName'
                      onsubmit='return confirm("Are you sure you want to remove customer $customerName?")'>
                  <input type='submit' class='button' value='Remove'>
                </form>
              </td>

              <td colspan='2'>
                <form method='post'
                 action='/add_account/$customerNumber/$customerName'>
                  <input type='submit' class='button' value='Add Account'>
                </form>
              </td>
            </tr>
__HTML;

            foreach ($customer['accounts'] as $account) {
              $accountNumber = $account['accountNumber'];
              $accountBalance = $account['accountBalance'];

echo <<< __HTML
            <tr>
              <td></td>
              <td>$accountNumber</td><td>$accountBalance</td>

              <td class='column1'>
                <form method='post'
                      action='/deposit/$customerNumber/$customerName/$accountNumber'>
                  <input type='submit' class='button' value='Deposit'>
                </form>
              </td>

              <td class='column1'>
                <form method='post'
                      action='/withdraw/$customerNumber/$customerName/$accountNumber'>
                  <input type='submit' class='button' value='Withdraw'>
                </form>
              </td>

              <td class='column1'>
                <form method='post'
                      action='/view_account/$customerNumber/$customerName/$accountNumber'>
                  <input type='submit' class='button' value='View'>
                </form>
              </td>

              <td class='column1'>
                <form method='post'
                      action='/remove_account/$customerNumber/$customerName/$accountNumber'
                      onsubmit='return confirm("Are you sure you want to remove account $accountNumber?")'>
                  <input type='submit' class='button' value='Remove'>
                </form>
              </td>
            </tr>
__HTML;
            }
          }
echo <<< __HTML
        </table>
__HTML;

      $text = ob_get_contents();
      ob_end_clean();
      return $text;
    }
  }