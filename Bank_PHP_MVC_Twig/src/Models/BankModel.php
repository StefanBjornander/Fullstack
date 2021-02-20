<?php

namespace Bank\Models;

//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class BankModel extends AbstractModel {
  public function customerList() {
    $customer_rows = $this->db->query("SELECT * FROM customer");
    if (!$customer_rows) die($this->db->errorInfo());
      
    $customers = [];
    foreach ($customer_rows as $customer_row) {
      $customerNumber = htmlspecialchars($customer_row["customer_number"]);
      $customerName = htmlspecialchars($customer_row["customer_name"]);
      $customer = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];        
        
      $account_query = "SELECT * FROM account WHERE customer_number = :customerNumber";
      $account_statement = $this->db->prepare($account_query);
      $account_result = $account_statement->execute(['customerNumber' => $customerNumber]);
      if (!$account_result) die($this->db->errorInfo());
      $account_rows = $account_statement->fetchAll();

      $accounts = [];
      foreach ($account_rows as $account_row) {
        $accountNumber = htmlspecialchars($account_row["account_number"]);
        $account = ['accountNumber' => $accountNumber];
        
        $balance_query = "SELECT SUM(amount) FROM history WHERE account_number = :accountNumber";
        $balance_statement = $this->db->prepare($balance_query);
        $balance_result = $balance_statement->execute(['accountNumber' => $accountNumber]);
        if (!$balance_result) die($this->db->errorInfo());

        $balance_rows = $balance_statement->fetchAll();
        $balance = htmlspecialchars($balance_rows[0]['SUM(amount)']);
        
        if ($balance === "") {
          $balance = "0";
        }

        $account['balance'] = $balance;
        $accounts[] = $account;
      }

      $customer['accounts'] = $accounts;
      $customers[] = $customer;
    }

    return $customers;
  }
}