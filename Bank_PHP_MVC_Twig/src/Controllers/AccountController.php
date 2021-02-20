<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;
use Bank\Models\AccountModel;

class AccountController extends AbstractController {
  public function deposit($customerNumber, $customerName, $accountNumber) {
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $this->render('Deposit.twig', $properties);
  }    

  public function depositDone($customerNumber, $customerName, $accountNumber) {
    $amount = $this->request->getParams()->getString("amount");
    $accountModel = new AccountModel($this->db);
    $accountModel->deposit($accountNumber, $amount);
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'amount' => $amount];
    return $this->render('DepositDone.twig', $properties);
  }
    
  public function withdraw($customerNumber, $customerName, $accountNumber) {
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $this->render('Withdraw.twig', $properties);
  }    

  public function withdrawDone($customerNumber, $customerName, $accountNumber) {
    $amount = $this->request->getParams()->getString("amount");
    $accountModel = new AccountModel($this->db);
    $accountModel->withdraw($accountNumber, $amount);
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'amount' => $amount];
    return $this->render('Withdraw_done.twig', $properties);
  }

  public function viewAccount($customerNumber, $customerName, $accountNumber) {
    $accountModel = new AccountModel($this->db);
    $result = $accountModel->viewAccount($accountNumber);
    $events = $result['events'];
    $balance = $result['balance'];
    
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'accountEvents' => $result['events'],
                   'accountBalance' => $result['balance']];
    return $this->render('ViewAccount.twig', $properties);
  }

  public function removeAccount($customerNumber, $customerName, $accountNumber) {
    $customerModel = new AccountModel($this->db);
    $accountbalance = $customerModel->removeAccount($accountNumber);

    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'accountBalance' => $accountbalance];
    return $this->render('AccountRemoved.twig', $properties);
  }
}