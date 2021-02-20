<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;
use Bank\Views\AddCustomerView;
use Bank\Views\CustomerAddedView;
use Bank\Views\EditCustomerView;
use Bank\Views\CustomerEditedView;
use Bank\Views\CustomerRemovedView;
use Bank\Views\AccountAddedView;

class CustomerController extends AbstractController {
  public function addCustomer() {
    $addCustomerView = new AddCustomerView();
    return $addCustomerView->render([]);
  }
    
  public function customerAdded() {
    $customerName = $this->request->getParams()->getString("customerName");
    $customerModel = new CustomerModel($this->db);
    $customerNumber = $customerModel->addCustomer($customerName);

    $customerAddedView = new CustomerAddedView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];
    return $customerAddedView->render($properties);
  }    

  public function editCustomer($customerNumber, $customerName) {
    $editCustomerView = new EditCustomerView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];
    return $editCustomerView->render($properties);
  }
    
  public function customerEdited($customerNumber, $customerOldName) {
    $customerNewName = $this->request->getParams()->getString("customerName");    
    $customerModel = new CustomerModel($this->db);
    $customerModel->editCustomer($customerNumber, $customerNewName);

    $customerEditedView = new CustomerEditedView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerOldName' => $customerOldName,
                   'customerNewName' => $customerNewName];
    return $customerEditedView->render($properties);
  }
    
  public function removeCustomer($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $numberOfAccounts = $customerModel->removeCustomer($customerNumber);

    $customerRemovedView = new CustomerRemovedView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'numberOfAccounts' => $numberOfAccounts];
    return $customerRemovedView->render($properties);
  }

  public function addAccount($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $accountNumber = $customerModel->addAccount($customerNumber);

    $accountAddedView = new AccountAddedView();
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $accountAddedView->render($properties);
  }
}