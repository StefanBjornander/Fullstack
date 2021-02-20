<?php

namespace App\Http\Controllers;
use App\Models\BankModel;

class MainMenuController extends Controller {
  public function customerList() {
    $bankModel = new BankModel();
    $customers = $bankModel->customerList();
    $properties = ["customers" => $customers];
    return view("MainMenu", $properties);
  }
}