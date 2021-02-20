<?php
namespace App\Models;
use DB;

class BankModel {
  public function customerList() {
    $customers = DB::table("customers")->get();

    foreach ($customers as $customer) {
      $accounts = DB::table("accounts")->where("customerNumber", "=", $customer->customerNumber)->get();

      foreach ($accounts as $account) {
        $balance = DB::table("events")->where("accountNumber", "=", $account->accountNumber)->sum("amount");
        $account->accountBalance = $balance;
      }

      $customer->accounts = $accounts;
    }

    return $customers;
  }
}
?>