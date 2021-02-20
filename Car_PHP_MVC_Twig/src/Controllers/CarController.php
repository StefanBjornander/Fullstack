<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CarModel;

class CarController extends AbstractController {
  public function carList() {
    $carModel = new CarModel($this->db);
    $cars = $carModel->carList();
    $properties = ["cars" => $cars];
    return $this->render("CarList.twig", $properties);
  }

  public function carAdd() {
    $makeModel = new CarModel($this->db);
    $makes = $makeModel->makeList();
    $colorModel = new CarModel($this->db);
    $colors = $colorModel->colorList();
    $properties = ["makes" => $makes, "colors" => $colors];
    return $this->render("CarAdd.twig", $properties);
  }
    
  public function carAdded() {
    $registration = $_POST["registration"];
//    $registration = $this->request->getParams()->getString("registration");
    $make = $this->request->getParams()->getString("make");
    $color = $this->request->getParams()->getString("color");
    $year = $this->request->getParams()->getString("year");
    $price = $this->request->getParams()->getString("price");
    $carModel = new CarModel($this->db);
    $ok = $carModel->carAdd($registration, $make, $color, $year, $price);
    $properties = ["ok" => $ok, "registration" => $registration, "make" => $make,
                   "color" => $color, "year" => $year, "price" => $price];
    return $this->render("CarAdded.twig", $properties);
  }    

  public function carEdit($registration, $make, $color, $year, $price) {
    $makeModel = new CarModel($this->db);
    $makes = $makeModel->makeList();
    $colorModel = new CarModel($this->db);
    $colors = $colorModel->colorList();
    $properties = ["registration" => $registration, "make" => $make,
                   "color" => $color, "year" => $year, "price" => $price,
                   "makes" => $makes, "colors" => $colors];
    return $this->render("CarEdit.twig", $properties);
  }
    
  public function carEdited($registration) {
    $make = $this->request->getParams()->getString("make");
    $color = $this->request->getParams()->getString("color");
    $year = $this->request->getParams()->getString("year");
    $price = $this->request->getParams()->getString("price");
    $carModel = new CarModel($this->db);
    $carModel->carEdit($registration, $make, $color, $year, $price);
    $properties = ["registration" => $registration, "make" => $make,
                   "color" => $color, "year" => $year, "price" => $price];
    return $this->render("CarEdited.twig", $properties);
  }    

  public function carRemoved($registration, $make, $color, $year) {
    $historysQuery = "UPDATE Event SET registration = NULL WHERE registration = :registration";
    $historyStatement = $this->db->prepare($historysQuery);
    $historysResult = $historyStatement->execute(["registration" => $registration]);
    if (!$historysResult) die($this->db->errorInfo()[2]);

    $carModel = new CarModel($this->db);
    $carModel->carRemoved($registration);
    $properties = ["registration" => $registration, "make" => $make,
                   "color" => $color, "year" => $year];
    return $this->render("carRemoved.twig", $properties);
  }
}