<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;
use Bank\Models\AccountModel;
use Bank\Views\DepositView;
use Bank\Views\DepositDoneView;
use Bank\Views\WithdrawView;
use Bank\Views\WithdrawDoneView;
use Bank\Views\ViewAccountView;
use Bank\Views\AccountRemovedView;

class AccountController extends AbstractController {
  public function deposit($customerNumber, $customerName, $accountNumber) {
    $depositView = new DepositView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $depositView->render($properties);
  }    

  public function depositDone($customerNumber, $customerName, $accountNumber) {
    $amount = $this->request->getParams()->getString("amount");
    $accountModel = new AccountModel($this->db);
    $accountModel->deposit($accountNumber, $amount);

    $depositDoneView = new DepositDoneView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'amount' => $amount];
    return $depositDoneView->render($properties);
  }
    
  public function withdraw($customerNumber, $customerName, $accountNumber) {
    $withdrawView = new WithdrawView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $withdrawView->render($properties);
  }    

  public function withdrawDone($customerNumber, $customerName, $accountNumber) {
    $amount = $this->request->getParams()->getString("amount");
    $accountModel = new AccountModel($this->db);
    $accountModel->withdraw($accountNumber, $amount);

    $withdrawDoneView = new WithdrawDoneView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'amount' => $amount];
    return $withdrawDoneView->render($properties);
  }

  public function viewAccount($customerNumber, $customerName, $accountNumber) {
    $accountModel = new AccountModel($this->db);
    $result = $accountModel->viewAccount($accountNumber);
    
    $viewAccountView = new ViewAccountView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'accountEvents' => $result['events'],
                   'accountBalance' => $result['balance']];
    return $viewAccountView->render($properties);
  }

  public function removeAccount($customerNumber, $customerName, $accountNumber) {
    $customerModel = new AccountModel($this->db);
    $accountbalance = $customerModel->removeAccount($accountNumber);

    $accountRemovedView = new AccountRemovedView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber,
                   'accountBalance' => $accountbalance];
    return $accountRemovedView->render($properties);
  }
}