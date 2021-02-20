<?php

namespace App\Http\Controllers;
use App\Models\AccountModel;
use Request;

class AccountController extends Controller {
  public function deposit($customerNumber, $customerName, $accountNumber) {
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return view("Deposit", $properties);
  }    

  public function depositDone($customerNumber, $customerName, $accountNumber) {
    $amount = Request::get("amount");
    $accountModel = new AccountModel();
    $accountModel->deposit($accountNumber, $amount);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "amount" => $amount];
    return view("DepositDone", $properties);
  }
    
  public function withdraw($customerNumber, $customerName, $accountNumber) {
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return view("Withdraw", $properties);
  }    

  public function withdrawDone($customerNumber, $customerName, $accountNumber) {
    $amount = Request::get("amount");
    $accountModel = new AccountModel();
    $accountModel->withdraw($accountNumber, $amount);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "amount" => $amount];
    return view("WithdrawDone", $properties);
  }

  public function transfer($fromCustomerNumber, $fromCustomerName, $fromAccountNumber) {
    $accountModel = new AccountModel();
    $accountTextArray = $accountModel->transfer($fromAccountNumber);
    $properties = ["fromCustomerNumber" => $fromCustomerNumber,
                   "fromCustomerName" => $fromCustomerName,
                   "fromAccountNumber" => $fromAccountNumber,
                   "accountTextArray" => $accountTextArray];
    return view("Transfer", $properties);
  }

  public function transferDone($fromCustomerNumber, $fromCustomerName, $fromAccountNumber) {
    $toAccountInfo = Request::get("toAccountInfo");
    $amount = Request::get("amount");
           
    $firstComma = strpos($toAccountInfo, ",");
    $lastComma = strrpos($toAccountInfo, ",");
    $toCustomerNumber = substr($toAccountInfo, 0, $firstComma);
    $toCustomerName = substr($toAccountInfo, $firstComma + 1, $lastComma - $firstComma - 1);
    $toAccountNumber = substr($toAccountInfo, $lastComma + 1);
      
    $accountModel = new AccountModel();
    $accountModel->transferDone($fromAccountNumber, $toAccountNumber, $amount);
    
    $properties = ["fromCustomerNumber" => $fromCustomerNumber,
                   "fromCustomerName" => $fromCustomerName,
                   "fromAccountNumber" => $fromAccountNumber,
                   "toCustomerNumber" => $toCustomerNumber,
                   "toCustomerName" => $toCustomerName,
                   "toAccountNumber" => $toAccountNumber,
                   "amount" => $amount];
    return view("TransferDone", $properties);
  }

  public function viewAccount($customerNumber, $customerName, $accountNumber) {
    $accountModel = new AccountModel();
    $result = $accountModel->viewAccount($accountNumber);
    $events = $result["events"];
    $accountBalance = $result["accountBalance"];
    
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "accountEvents" => $result["events"],
                   "accountBalance" => $result["accountBalance"]];
    return view("ViewAccount", $properties);
  }

  public function removeAccount($customerNumber, $customerName, $accountNumber) {
    $customerModel = new AccountModel();
    $accountbalance = $customerModel->removeAccount($accountNumber);

    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "accountBalance" => $accountbalance];
    return view("AccountRemoved", $properties);
  }
}