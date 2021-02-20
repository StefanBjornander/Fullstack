<?php
namespace Bank\Controllers;
use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;

class CustomerController extends AbstractController {
  public function customerList() {
    $customerModel = new CustomerModel($this->db);
    $customers = $customerModel->customerList();
    $twig = $this->view;
    $properties = ["customers" => $customers];
    return $twig->render("CustomerList.twig", $properties);
  }
    
  public function customerAdd() {
    return $this->render("CustomerAdd.twig", []);
  }
    
  public function customerAdded() {
    $person = $this->request->getParams()->getString("person");
    $name = $this->request->getParams()->getString("name");
    $address = $this->request->getParams()->getString("address");
    $postal = $this->request->getParams()->getString("postal");
    $phone = $this->request->getParams()->getString("phone");
    $customerModel = new CustomerModel($this->db);
    $ok = $customerModel->customerAdd($person, $name, $address, $postal, $phone);    
    $properties = ["ok" => $ok, "person" => $person, "name" => $name,
                   "address" => $address, "postal" => $postal, "phone" => $phone];
    return $this->render("CustomerAdded.twig", $properties);
  }    

  public function customerEdit($person, $name, $address, $postal, $phone) {
    $properties = ["person" => $person, "name" => $name,
                   "address" => $address, "postal" => $postal, "phone" => $phone];
    return $this->render("CustomerEdit.twig", $properties);
  }
    
  public function customerEdited($person) {
    $name = $this->request->getParams()->getString("name");
    $address = $this->request->getParams()->getString("address");
    $postal = $this->request->getParams()->getString("postal");
    $phone = $this->request->getParams()->getString("phone");
    $customerNewName = $this->request->getParams()->getString("customerName");    
    $customerModel = new CustomerModel($this->db);
    $customerModel->customerEdit($person, $name, $address, $postal, $phone);
    $properties = ["person" => $person, "name" => $name,
                   "address" => $address, "postal" => $postal, "phone" => $phone];
    return $this->render("CustomerEdited.twig", $properties);
  }    
    
  public function customerRemoved($person, $name, $address, $postal, $phone) {
    $customerModel = new CustomerModel($this->db);
    $ok = $customerModel->customerRemoved($person);
    $properties = ["ok" => $ok, "person" => $person, "name" => $name,
                   "address" => $address, "postal" => $postal, "phone" => $phone];
    return $this->render("customerRemoved.twig", $properties);
  }
}