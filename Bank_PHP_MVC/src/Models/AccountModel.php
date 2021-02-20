<?php

namespace Bank\Models;

//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class AccountModel extends AbstractModel {
  public function deposit($accountNumber, $amount) {
    $customer_query = "INSERT INTO history(account_number, amount) " .
                      "VALUES(:accountNumber, :amount)";
    $customer_statement = $this->db->prepare($customer_query);
    $customer_parameters = ['accountNumber' => $accountNumber, 'amount' => $amount];
    $customer_result = $customer_statement->execute($customer_parameters);
    if (!$customer_result) die($this->db->errorInfo()[2]);
  }

  public function withdraw($accountNumber, $amount) {
    $customer_query = "INSERT INTO history(account_number, amount) " .
                      "VALUES(:accountNumber, :amount)";
    $customer_statement = $this->db->prepare($customer_query);
    $negetiveAmount = -$amount;
    $customer_parameters = ['accountNumber' => $accountNumber, 'amount' => $negetiveAmount];
    $customer_result = $customer_statement->execute($customer_parameters);
    if (!$customer_result) die($this->db->errorInfo()[2]);
  }

  public function viewAccount($accountNumber) {
    $events_query = "SELECT * FROM history WHERE account_number = :accountNumber";
    $events_statement = $this->db->prepare($events_query);
    $events_result = $events_statement->execute(['accountNumber' => $accountNumber]);
    if (!$events_result) die($this->db->errorInfo()[2]);
//    $events_size = $events_statement->rowCount();
    $events_rows = $events_statement->fetchAll();

    $events = [];
    foreach ($events_rows as $events_row) {
      $time = htmlspecialchars($events_row["time"]);
      $amount = htmlspecialchars($events_row["amount"]);
      $events[] = ['time' => $time, 'amount' => $amount];
    }
    
    if (count($events) > 0) {
      $balance_query = "SELECT SUM(amount) FROM history WHERE account_number = :accountNumber";
      $balance_statement = $this->db->prepare($balance_query);
      $balance_statement->execute(['accountNumber' => $accountNumber]);
      if (!$balance_statement) die($this->db->errorInfo());
      $balance_rows = $balance_statement->fetchAll();
      $balance = htmlspecialchars($balance_rows[0]['SUM(amount)']);
    }
    else {
      $balance = 0;
    }

    return ['events' => $events, 'balance' => $balance];
  }

  public function removeAccount($accountNumber) {
    $balance_query = "SELECT SUM(amount) FROM history WHERE account_number = :accountNumber";
    $balance_statement = $this->db->prepare($balance_query);
    $balance_statement->execute(['accountNumber' => $accountNumber]);
    if (!$balance_statement) die($this->db->errorInfo()[2]);
    $balance_rows = $balance_statement->fetchAll();
    $account_balance = htmlspecialchars($balance_rows[0]['SUM(amount)']);
    
    if (($account_balance == "") || ($account_balance == 0)) {
      if ($account_balance == 0) {
        $events_query = "DELETE FROM history WHERE account_number = :accountNumber";
        $events_statement = $this->db->prepare($events_query);
        $events_statement->execute(['accountNumber' => $accountNumber]);
        if (!$events_statement) die($this->db->errorInfo()[2]);
      }

      $account_query = "DELETE FROM account WHERE account_number = :accountNumber";
      $account_statement = $this->db->prepare($account_query);
      $account_statement->execute(['accountNumber' => $accountNumber]);
      if (!$account_statement) die($this->db->errorInfo()[2]);
    }

    if ($account_balance == "") {
      $account_balance = 0;
    }

    return $account_balance;
  }  
}