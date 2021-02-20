<?php

namespace Bank\Controllers;

use Bank\Exceptions\NotFoundException;
use Bank\Models\CustomerModel;
use Bank\Models\CarModel;
use Bank\Models\EventModel;

class EventController extends AbstractController {
  public function eventList() {
    $eventModel = new EventModel($this->db);
    $properties = $eventModel->eventList();
    return $this->render("History.twig", $properties);
  }

  public function checkOut() {
    $customerModel = new CustomerModel($this->db);
    $customers = $customerModel->customerList();
    $carModel = new CarModel($this->db);
    $freeCars = $carModel->freeCarList();
    $properties = ["customers" => $customers, "freeCars" => $freeCars];
    return $this->render("CheckOut.twig", $properties);
  }

  public function checkedOut() {
    $person = $this->request->getParams()->getString("person");
    $registration = $this->request->getParams()->getString("registration");
    $eventModel = new EventModel($this->db);
    $eventModel->checkOut($person, $registration);
    $customerModel = new CustomerModel($this->db);
    $customer = $customerModel->lookup($person, $registration);
    $carModel = new CarModel($this->db);
    $car = $carModel->lookup($registration);
    $properties = ["customer" => $customer, "car" => $car];
    return $this->render("CheckedOut.twig", $properties);
  }

  public function checkIn() {
    $carModel = new CarModel($this->db);
    $bookedCars = $carModel->bookedCarList();
    $properties = ["bookedCars" => $bookedCars];
    return $this->render("CheckIn.twig", $properties);
  }

  public function checkedIn() {
    $registration = $this->request->getParams()->getString("registration");
    $eventModel = new EventModel($this->db);
    $person = $eventModel->checkIn($registration);
    $customerModel = new CustomerModel($this->db);
    $customer = $customerModel->lookup($person);
    $carModel = new CarModel($this->db);
    $car = $carModel->lookup($registration);
    $properties = ["car" => $car, "customer" => $customer];
    return $this->render("CheckedIn.twig", $properties);
  }
}