<?php

namespace Bank\Models;

use DateTime;
//use Bank\Domain\Bank;
use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use PDO;

class EventModel extends AbstractModel {
  public function eventList() {
    $eventRows = $this->db->query("SELECT * FROM Event");
    if (!$eventRows) die("Error Event List.");
      
    $events = [];
    foreach ($eventRows as $eventRow) {
      $registration = htmlspecialchars($eventRow["registration"]);
      $person = htmlspecialchars($eventRow["person"]);
      $checkOutTime = htmlspecialchars($eventRow["checkOutTime"]);
      $checkInTime = htmlspecialchars($eventRow["checkInTime"]);
      $days = htmlspecialchars($eventRow["days"]);
      $cost = htmlspecialchars($eventRow["cost"]);
      $event = ["registration" => $registration,
                "person" => $person,
                "checkOutTime" => $checkOutTime,
                "checkInTime" => $checkInTime,
                "days" => $days, "cost" => $cost];
      $events[] = $event;
    }
    
    $eventQuery = "SELECT sum(cost) FROM Event";
    $eventStatement = $this->db->prepare($eventQuery);
    $eventResult = $eventStatement->execute();
    if (!$eventResult) die("Fatal error."); // $this->db->errorInfo());
    $eventRow = $eventStatement->fetch();

    if ($eventRow[0] != null) {
      $sum = $eventRow[0];
    }
    else {
      $sum = 0;
    }

    return ["events" => $events, "sum" => $sum];
  }

  public function checkOutX($person, $registration) {
    $eventsQuery = "INSERT INTO Event(inOrOut, person, registration) " .
                      "VALUES('out', :person, :registration)";
    $eventStatement = $this->db->prepare($eventsQuery);
    $eventStatement->execute(["person" => $person, "registration" => $registration]);
    if (!$eventStatement) die("Fatal error."); // $this->db->errorInfo());
  }

  public function checkInX($person, $registration) {
    $eventsQuery = "INSERT INTO Event(inOrOut, person, registration) " .
                      "VALUES('in', :person, :registration)";
    $eventStatement = $this->db->prepare($eventsQuery);
    $eventStatement->execute(["person" => $person, "registration" => $registration]);
    if (!$eventStatement) die("Fatal error."); // $this->db->errorInfo());
  }

  public function checkOut($person, $registration) {
    $eventsQuery = "update Car set person = :person, time = current_timestamp() where registration = :registration";
    $eventStatement = $this->db->prepare($eventsQuery);
    $eventStatement->execute(["person" => $person, "registration" => $registration]);
    if (!$eventStatement) die("Fatal error."); // $this->db->errorInfo());
  }

  public function checkIn($registration) {
    $carQuery = "SELECT * FROM Car where registration = :registration";
    $carStatement = $this->db->prepare($carQuery);
    $carResult = $carStatement->execute(["registration" => $registration]);
    if (!$carResult) die("Fatal error."); // $this->db->errorInfo());
    $carRow = $carStatement->fetch();
    $person = htmlspecialchars($carRow["person"]);
    $price = htmlspecialchars($carRow["price"]);
    $checkOutTime = new DateTime(htmlspecialchars($carRow["time"]));
    $checkInTime = new DateTime();

    $eventsQuery = "update Car set person = null, time = null where registration = :registration";
    $eventStatement = $this->db->prepare($eventsQuery);
    $eventStatement->execute(["registration" => $registration]);
    if (!$eventStatement) die("Fatal error."); // $this->db->errorInfo());

    $seconds = $checkInTime->getTimeStamp() - $checkOutTime->getTimeStamp();
    $days = intdiv($seconds, 86400) + ((($seconds % 86400) > 0) ? 1 : 0);
    $cost = $days * $price;
    
    $eventsQuery = "insert into Event(registration, person, checkOutTime, checkInTime, days, cost) " .
                   "values(:registration, :person, :checkOutTime, :checkInTime, :days, :cost)";
    $eventStatement = $this->db->prepare($eventsQuery);
    $eventStatement->execute(["registration" => $registration,
                              "person" => $person,
                              "checkOutTime" => $checkOutTime->format("Y-m-d H:i:s"),
                              "checkInTime" => $checkInTime->format("Y-m-d H:i:s"),
                              "days" => $days,
                              "cost" => $cost]);
    if (!$eventStatement) die("Fatal error."); // $this->db->errorInfo());
    return $person;
  }
}