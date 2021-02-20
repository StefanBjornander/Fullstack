<?php
  require_once("Login.php");
  require_once("AddCustomer.php");
  require_once("CustomerAdded.php");
  require_once("EditCustomer.php");
  require_once("CustomerEdited.php");
  require_once("CustomerRemoved.php");
  require_once("Deposit.php");
  require_once("DepositDone.php");
  require_once("Withdraw.php");
  require_once("WithdrawDone.php");
  require_once("AccountAdded.php");
  require_once("AccountRemoved.php");
  require_once("ViewAccount.php");
  require_once("MainMenu.php");

  $connection = login();
  
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<body>";
  
  if (isset($_POST["state"])) {
    switch ($_POST["state"]) {
      case "add_customer":
        add_customer($connection);
        break;

      case "customer_added":
        customer_added($connection);
        break;

      case "edit_customer":
        edit_customer($connection);
        break;

      case "customer_edited":
        customer_edited($connection);
        break;

      case "customer_removed":
        customer_removed($connection);
        break;
    
      case "deposit":
        deposit($connection);
        break;

      case "deposit_done":
        deposit_done($connection);
        break;

      case "withdraw":
        withdraw($connection);
        break;

      case "customer_removed":
        withdraw_done($connection);
        break;

      case "withdraw":
        withdraw($connection);
        break;

      case "withdraw_done":
        withdraw_done($connection);
        break;
    
      case "view_account":
        view_account($connection);
        break;

      case "account_added":
        account_added($connection);
        break;

      case "account_removed":
        account_removed($connection);
        break;
    }
  }

  main_menu($connection);
  echo "</body>";
  echo "</html>";
?>