<?php
namespace App\Models;
use DB;

class CustomerModel {
  public function addCustomer($customerName) {
    /*$customer = new Customer(); // Eloquent Object Relation Mapping
    $customer->customerName = $customerName;
    $customer->save();
    return $customer->customerNumber;
    */
      
    // Query Builder
    return DB::table("customers")->insertGetId(["customerName" => $customerName]);
  }

  public function editCustomer($customerNumber, $customerNewName) {
    /*$customer = Customer::find($customerNumber);
    $customer->customerName = $customerNewName;
    $customer->save();*/
      
    // Query Builder
    DB::table("customers")->where("customerNumber", "=", $customerNumber)->update(["customerName" => $customerNewName]);
  }

  public function removeCustomer($customerNumber) {
    $numberOfAccounts = DB::table("accounts")->where("customerNumber", "=", $customerNumber)->count("*");

    if ($numberOfAccounts == 0) {
      DB::table("customers")->where("customerNumber", "=", $customerNumber)->delete();
    }

    return $numberOfAccounts;
  }  

  public function addAccount($customerNumber) {
    /*$account = new Account();
    $account->customerNumber = $customerNumber;
    $account->save();
    return $account->accountNumber;*/
    return DB::table("accounts")->insertGetId(["customerNumber" => $customerNumber]);
 }  
}