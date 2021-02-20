<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;

class CustomerController extends AbstractController {
  public function addCustomer() {
    return $this->render('AddCustomer.twig', []);
  }
    
  public function customerAdded() {
    $customerName = $this->request->getParams()->getString("customerName");
    $customerModel = new CustomerModel($this->db);
    $customerNumber = $customerModel->addCustomer($customerName);
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];
    return $this->render('CustomerAdded.twig', $properties);
  }    

  public function editCustomer($customerNumber, $customerName) {
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName];
    return $this->render('EditCustomer.twig', $properties);
  }
    
  public function customerEdited($customerNumber, $customerOldName) {
    $customerNewName = $this->request->getParams()->getString("customerName");    
    $customerModel = new CustomerModel($this->db);
    $customerModel->editCustomer($customerNumber, $customerNewName);
    $properties = ['customerNumber' => $customerNumber,
                   'customerOldName' => $customerOldName,
                   'customerNewName' => $customerNewName];
    return $this->render('CustomerEdited.twig', $properties);
  }    
    
  public function removeCustomer($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $numberOfAccounts = $customerModel->removeCustomer($customerNumber);
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'numberOfAccounts' => $numberOfAccounts];
    return $this->render('CustomerRemoved.twig', $properties);
  }

  public function addAccount($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $accountNumber = $customerModel->addAccount($customerNumber);
    $properties = ['customerNumber' => $customerNumber,
                   'customerName' => $customerName,
                   'accountNumber' => $accountNumber];
    return $this->render('AccountAdded.twig', $properties);
  }
}