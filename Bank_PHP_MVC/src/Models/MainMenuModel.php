<?php

namespace Bank\Models;

//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class MainMenuModel extends AbstractModel {
  public function customerList() {
    $customer_rows = $this->db->query("SELECT * FROM customer");
    if (!$customer_rows) die($this->db->errorInfo());
      
    $customers = [];
    foreach ($customer_rows as $customer_row) {
      $customerNumber = htmlspecialchars($customer_row["customerNumber"]);
      $customerName = htmlspecialchars($customer_row["customerName"]);
      $customer = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];        
        
      $account_query = "SELECT * FROM account WHERE customer_number = :customerNumber";
      $account_statement = $this->db->prepare($account_query);
      $account_result = $account_statement->execute(['customerNumber' => $customerNumber]);
      if (!$account_result) die($this->db->errorInfo());
      $account_rows = $account_statement->fetchAll();

      $accounts = [];
      foreach ($account_rows as $account_row) {
        $accountNumber = htmlspecialchars($account_row["accountNumber"]);
        $account = ['accountNumber' => $accountNumber];
        
        $balance_query = "SELECT SUM(amount) FROM history WHERE accountNumber = :accountNumber";
        $balance_statement = $this->db->prepare($balance_query);
        $balance_result = $balance_statement->execute(['accountNumber' => $accountNumber]);
        if (!$balance_result) die($this->db->errorInfo());

        $balance_rows = $balance_statement->fetchAll();
        $account_balance = htmlspecialchars($balance_rows[0]['SUM(amount)']);
        
        if ($account_balance === "") {
          $account_balance = "0";
        }

        $account['balance'] = $account_balance;
        $accounts[] = $account;
      }

      $customer['accounts'] = $accounts;
      $customers[] = $customer;
    }
      
    return $customers;
  }
}