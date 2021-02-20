<?php
namespace App\Models;
use DB;

class AccountModel {
  public function deposit($accountNumber, $amount) {
    /*$event = new Event();
    $event->accountNumber = $accountNumber;
    $event->amount = $amount;
    $event->save();
    return $event->customerNumber;*/
    return DB::table("events")->insertGetId(["accountNumber" => $accountNumber, "amount" => $amount]);
  }

  public function withdraw($accountNumber, $amount) {
    /*$event = new Event();
    $event->accountNumber = $accountNumber;
    $event->amount = -$amount;
    $event->save();
    return $event->customerNumber;*/
    return DB::table("events")->insertGetId(["accountNumber" => $accountNumber, "amount" => -$amount]);
  }

  public function viewAccount($accountNumber) {
    $events = DB::table("events")->where("accountNumber", "=", $accountNumber)->get();
    $accountBalance = DB::table("events")->where("accountNumber", "=", $accountNumber)->sum("amount");
    return ["events" => $events, "accountBalance" => $accountBalance];
  }

  public function transfer($fromAccountNumber) {
    $accountInfoArray = DB::table("customers")->
                        join("accounts", "customers.customerNumber", "=", "accounts.customerNumber")->
                        where("accounts.accountNumber", "!=", $fromAccountNumber)->get();
    
    $accountTextArray = [];
    foreach ($accountInfoArray as $info) {
      $accountTextArray[] = $info->customerNumber . "," . $info->customerName . "," . $info->accountNumber;
    }
    
    return $accountTextArray;
  }

  public function transferDone($fromAccountNumber, $toAccountNumber, $amount) {
    /*$fromEvent = new Event();
    $fromEvent->accountNumber = $fromAccountNumber;
    $fromEvent->amount = -$amount;
    $fromEvent->save();

    $toEvent = new Event();
    $toEvent->accountNumber = $toAccountNumber;
    $toEvent->amount = $amount;
    $toEvent->save();*/

    DB::beginTransaction();
    DB::table("events")->insert(["accountNumber" => $fromAccountNumber, "amount" => -$amount]);
    DB::table("events")->insert(["accountNumber" => $toAccountNumber, "amount" => $amount]);
    DB::commit();
  }

  public function removeAccount($accountNumber) {
    $accountBalance = DB::table("events")->where("accountNumber", "=", $accountNumber)->sum("amount");
   
    if ($accountBalance == 0) {
      DB::table("events")->where("accountNumber", "=", $accountNumber)->delete();
      DB::table("accounts")->where("accountNumber", "=", $accountNumber)->delete();
    }

    return $accountBalance;
  }  
}