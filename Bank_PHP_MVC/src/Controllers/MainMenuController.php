<?php

namespace Bank\Controllers;

use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use Bank\Models\BankModel;
use Bank\Views\MainMenuView;

class MainMenuController extends AbstractController {
  public function customerList(): string {
    $bankModel = new BankModel($this->db);
    $customers = $bankModel->customerList();
    $properties = ['customers' => $customers];
    return MainMenuView::render($properties);
  }
}