<?php

namespace Bank\Models;

//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class CustomerModel extends AbstractModel {
  public function customerList() {
    $customerRows = $this->db->query("SELECT * FROM Customer");
    if (!$customerRows) die("Error Customer List.");
      
    $customers = [];
    foreach ($customerRows as $customerRow) {
      $person = htmlspecialchars($customerRow["person"]);
      $name = htmlspecialchars($customerRow["name"]);
      $address = htmlspecialchars($customerRow["address"]);
      $postal = htmlspecialchars($customerRow["postal"]);
      $phone = htmlspecialchars($customerRow["phone"]);
      $customer = ["person" => $person,
                   "name" => $name,
                   "address" => $address,
                   "postal" => $postal,
                   "phone" => $phone,
                   "rent" => $this->doesRent($person)];
      $customers[] = $customer;
    }
    
    return $customers;
  }

  private function doesRent($person) {
    $carQuery = "SELECT person FROM Car WHERE person = :person";
    $carStatement = $this->db->prepare($carQuery);
    $carResult = $carStatement->execute(["person" => $person]);
    if (!$carResult) die($this->db->errorInfo());
    return ($carStatement->rowCount() > 0);
  }
  
  public function customerAdd($person, $name, $address, $postal, $phone) {
    $customersQuery = "INSERT INTO Customer(person, name, address, postal, phone) " .
                      "VALUES(:person, :name, :address, :postal, :phone)";
    $customerStatement = $this->db->prepare($customersQuery);
    $customerStatement->bindValue("person", $person, PDO::PARAM_STR);
    $customerStatement->bindValue("name", $name, PDO::PARAM_STR);
    $customerStatement->bindValue("address", $address, PDO::PARAM_STR);
    $customerStatement->bindValue("postal", $postal, PDO::PARAM_STR);
    $customerStatement->bindValue("phone", $phone, PDO::PARAM_STR);
    $result = $customerStatement->execute();
    //echo "result " . ($result ? "Yes" : "No") . " " . $customerStatement->rowCount() . "<br>";        
    if (!$customerStatement) die("Fatal error."); // $this->db->errorInfo());
    return $result;
  }

  public function customerEdit($person, $name, $address, $postal, $phone) {
    $customersQuery = "update Customer set name = :name, address = :address, " .
                      "postal = :postal, phone = :phone where person = :person";
    $customerStatement = $this->db->prepare($customersQuery);
    $customerStatement->bindValue("person", $person, PDO::PARAM_STR);
    $customerStatement->bindValue("name", $name, PDO::PARAM_STR);
    $customerStatement->bindValue("address", $address, PDO::PARAM_STR);
    $customerStatement->bindValue("postal", $postal, PDO::PARAM_STR);
    $customerStatement->bindValue("phone", $phone, PDO::PARAM_STR);
    $customerStatement->execute();
    if (!$customerStatement) die("Fatal error."); // $this->db->errorInfo());
  }

  public function customerRemoved($person) {
    $historysQuery = "UPDATE Event SET person = NULL WHERE person = :person";
    $historyStatement = $this->db->prepare($historysQuery);
    $historyStatement->bindValue("person", $person, PDO::PARAM_STR);
    $historysResult = $historyStatement->execute();
    if (!$historysResult) die($this->db->errorInfo()[2]);

    $customersQuery = "DELETE FROM Customer WHERE person = :person";
    $customerStatement = $this->db->prepare($customersQuery);
    $customerStatement->bindValue("person", $person, PDO::PARAM_STR);
    $customersResult = $customerStatement->execute();
    if (!$customersResult) die($this->db->errorInfo()[2]);
  }
  
  public function lookup($person) {
    $customersQuery = "SELECT * FROM Customer where person = :person";
    $customerStatement = $this->db->prepare($customersQuery);
    $customerResult = $customerStatement->execute(["person" => $person]);
    if (!$customerResult) die("Fatal error."); // $this->db->errorInfo());
    $customerRow = $customerStatement->fetch();
    $person = htmlspecialchars($customerRow["person"]);
    $name = htmlspecialchars($customerRow["name"]);
    $address = htmlspecialchars($customerRow["address"]);
    $postal = htmlspecialchars($customerRow["postal"]);
    $phone = htmlspecialchars($customerRow["phone"]);
    $customer = ["person" => $person,
                 "name" => $name,
                 "address" => $address,
                 "postal" => $postal,
                 "phone" => $phone];
    return $customer;
  }
}