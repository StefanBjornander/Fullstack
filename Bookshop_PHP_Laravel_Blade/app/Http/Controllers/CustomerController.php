<?php

namespace App\Http\Controllers;
use App\Models\CustomerModel;
use Request;

class CustomerController extends Controller {
  public function addCustomer() {
    return view("AddCustomer", []);
  }
    
  public function customerAdded() {
    $customerName = Request::get("customerName");
    $customerModel = new CustomerModel();
    $customerNumber = $customerModel->addCustomer($customerName);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName];
    return view("CustomerAdded", $properties);
  }    

  public function editCustomer($customerNumber, $customerName) {
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName];
    return view("EditCustomer", $properties);
  }
    
  public function customerEdited($customerNumber, $customerOldName) {
    $customerNewName = Request::get("customerName");
    $customerModel = new CustomerModel();
    $customerModel->editCustomer($customerNumber, $customerNewName);
    $properties = ["customerNumber" => $customerNumber,
                   "customerOldName" => $customerOldName,
                   "customerNewName" => $customerNewName];
    return view("CustomerEdited", $properties);
  }    
    
  public function removeCustomer($customerNumber, $customerName) {
    $customerModel = new CustomerModel();
    $numberOfAccounts = $customerModel->removeCustomer($customerNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "numberOfAccounts" => $numberOfAccounts];
    return view("CustomerRemoved", $properties);
  }

  public function addAccount($customerNumber, $customerName) {
    $customerModel = new CustomerModel();
    $accountNumber = $customerModel->addAccount($customerNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return view("AccountAdded", $properties);
  }
}