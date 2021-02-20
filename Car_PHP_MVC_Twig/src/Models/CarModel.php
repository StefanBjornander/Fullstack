<?php

namespace Bank\Models;

use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class CarModel extends AbstractModel {
  public function carList() {
    $carRows = $this->db->query("SELECT * FROM Car");
    if (!$carRows) die($this->db->errorInfo());

    $cars = [];
    foreach ($carRows as $carRow) {
      $registration = htmlspecialchars($carRow["registration"]);
      $make = htmlspecialchars($carRow["make"]);
      $color = htmlspecialchars($carRow["color"]);
      $year = htmlspecialchars($carRow["year"]);
      $price = htmlspecialchars($carRow["price"]);
      $person = htmlspecialchars($carRow["person"]);
      $time = htmlspecialchars($carRow["time"]);
      $car = ["registration" => $registration,
              "make" => $make, "color" => $color,
              "year" => $year, "price" => $price,
              "person" => $person, "time" => $time];
      $cars[] = $car;
    }
    return $cars;
  }

  public function carAdd($registration, $make, $color, $year, $price) {
    $carsQuery = "INSERT INTO Car(registration, make, color, year, price) " .
                 "VALUES(:registration, :make, :color, :year, :price)";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsStatement->bindValue("registration", $registration, PDO::PARAM_STR);
    $carsStatement->bindValue("make", $make, PDO::PARAM_STR);
    $carsStatement->bindValue("color", $color, PDO::PARAM_STR);
    $carsStatement->bindValue("year", $year, PDO::PARAM_INT);
    $carsStatement->bindValue("price", $price, PDO::PARAM_STR);
    $result = $carsStatement->execute();
    if (!$carsStatement) die("Fatal error."); // $this->db->errorInfo());
    return $result;
  }

  public function carEdit($registration, $make, $color, $year, $price) {
    $carsQuery = "UPDATE Car SET make = :make, color = :color, year = :year, " .
                 "price = :price WHERE registration = :registration";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsStatement->bindValue("registration", $registration, PDO::PARAM_STR);
    $carsStatement->bindValue("make", $make, PDO::PARAM_STR);
    $carsStatement->bindValue("color", $color, PDO::PARAM_STR);
    $carsStatement->bindValue("year", $year, PDO::PARAM_INT);
    $carsStatement->bindValue("price", $price, PDO::PARAM_STR);
    $carsResult = $carsStatement->execute();
    if (!$carsResult) die($this->db->errorInfo()[2]);
  }

  public function carRemoved($registration) {
    $carsQuery = "DELETE FROM Car WHERE registration = :registration";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsStatement->bindValue("registration", $registration, PDO::PARAM_STR);
    $carsResult = $carsStatement->execute();
    if (!$carsResult) die($this->db->errorInfo()[2]);
  }  

  public function lookup($registration) {
    $carsQuery = "SELECT * FROM Car where registration = :registration";
    $carStatement = $this->db->prepare($carsQuery);
    $carResult = $carStatement->execute(["registration" => $registration]);
    if (!$carResult) die("Fatal error."); // $this->db->errorInfo());
    $carRow = $carStatement->fetch();
    $make = htmlspecialchars($carRow["make"]);
    $color = htmlspecialchars($carRow["color"]);
    $year = htmlspecialchars($carRow["year"]);
    $car = ["registration" => $registration,
            "make" => $make, "color" => $color,
            "year" => $year, "year" => $year];
    return $car;
  }  
  
  public function checkedOutCarList() {
    $carRows = $this->db->query("SELECT * FROM Car where person is not null");
    if (!$carRows) die($this->db->errorInfo());
      
    $cars = [];
    foreach ($carRows as $carRow) {
      $registration = htmlspecialchars($carRow["registration"]);
      $make = htmlspecialchars($carRow["make"]);
      $color = htmlspecialchars($carRow["color"]);
      $year = htmlspecialchars($carRow["year"]);
      $price = htmlspecialchars($carRow["price"]);
      $car = ["registration" => $registration,
              "make" => $make,
              "color" => $color,
              "year" => $year,
              "price" => $price];
      $cars[] = $car;
    }
      
    return $cars;
  }  
  
  public function freeCarList() {
    $carRows = $this->db->query("SELECT * FROM Car where person is null");
    if (!$carRows) die($this->db->errorInfo());
      
    $cars = [];
    foreach ($carRows as $carRow) {
      $registration = htmlspecialchars($carRow["registration"]);
      $make = htmlspecialchars($carRow["make"]);
      $color = htmlspecialchars($carRow["color"]);
      $year = htmlspecialchars($carRow["year"]);
      $price = htmlspecialchars($carRow["price"]);
      $car = ["registration" => $registration,
              "make" => $make,
              "color" => $color,
              "year" => $year,
              "price" => $price];
      $cars[] = $car;
    }
      
    return $cars;
  }  
  
  public function bookedCarList() {
    $carRows = $this->db->query("SELECT * FROM Car where person is not null");
    if (!$carRows) die($this->db->errorInfo());
      
    $cars = [];
    foreach ($carRows as $carRow) {
      $registration = htmlspecialchars($carRow["registration"]);
      $make = htmlspecialchars($carRow["make"]);
      $color = htmlspecialchars($carRow["color"]);
      $year = htmlspecialchars($carRow["year"]);
      $price = htmlspecialchars($carRow["price"]);
      $car = ["registration" => $registration,
              "make" => $make,
              "color" => $color,
              "year" => $year,
              "price" => $price];
      $cars[] = $car;
    }
      
    return $cars;
  }
  
  public function makeList() {
    $makeRows = $this->db->query("SELECT make FROM Make");
    if (!$makeRows) die($this->db->errorInfo());

    $makes = [];
    foreach ($makeRows as $makeRow) {
      $make = htmlspecialchars($makeRow["make"]);
      $makes[] = $make;
    }
      
    return $makes;
  }
  
  public function colorList() {
    $colorRows = $this->db->query("SELECT color FROM Color");
    if (!$colorRows) die($this->db->errorInfo());

    $colors = [];
    foreach ($colorRows as $colorRow) {
      $color = htmlspecialchars($colorRow["color"]);
      $colors[] = $color;
    }
      
    return $colors;
  }
}