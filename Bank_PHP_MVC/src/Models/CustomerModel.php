<?php

namespace Bank\Models;

//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class CustomerModel extends AbstractModel {
  public function addCustomer($customerName) {
    $customer_query = "INSERT INTO customer(customer_name) " .
                      "VALUES(:customerName)";
    $customer_statement = $this->db->prepare($customer_query);
    $customer_statement->execute(['customerName' => $customerName]);
    if (!$customer_statement) die("Fatal error."); // $this->db->errorInfo());
    $customerNumber = $this->db->lastInsertId();
    return $customerNumber;
  }

  public function editCustomer($customerNumber, $customerNewName) {
    $customer_query = "UPDATE customer SET customer_name = :customerName " .
                      "WHERE customer_number = :customerNumber";
    $customer_statement = $this->db->prepare($customer_query);
    $customer_parameters = ['customerName' => $customerNewName,
                            'customerNumber' => $customerNumber];
    $customer_result = $customer_statement->execute($customer_parameters);
    if (!$customer_result) die($this->db->errorInfo()[2]);
  }

  public function removeCustomer($customerNumber) {
    $account_query = "SELECT COUNT(*) FROM account WHERE customer_number = :customerNumber";
    $account_statement = $this->db->prepare($account_query);
    $account_result = $account_statement->execute(['customerNumber' => $customerNumber]);
    if (!$account_result) die($this->db->errorInfo()[2]);
    $account_rows = $account_statement->fetchAll();
    $numberOfAccounts = htmlspecialchars($account_rows[0]['COUNT(*)']);
    
    if ($numberOfAccounts == 0) {
      $customer_query = "DELETE FROM customer WHERE customer_number = :customerNumber";
      $customer_statement = $this->db->prepare($customer_query);
      $customer_result = $customer_statement->execute(['customerNumber' => $customerNumber]);
      if (!$customer_result) die($this->db->errorInfo()[2]);
    }

    return $numberOfAccounts;
  }  

  public function addAccount($customerNumber) {
    $account_query = "INSERT INTO account(customer_number) VALUES(:customerNumber)";
    $account_statement = $this->db->prepare($account_query);
    $account_statement->execute(['customerNumber' => $customerNumber]);
    if (!$account_statement) die($this->db->errorInfo()[2]);
    $accountNumber = $this->db->lastInsertId();
    return $accountNumber;
  }  
}