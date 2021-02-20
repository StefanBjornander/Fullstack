<?php

namespace Bank\Controllers;

use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use Bank\Models\BankModel;

class MainMenuController extends AbstractController {
  public function customerList(): string {
    $bankModel = new BankModel($this->db);
    $customers = $bankModel->customerList();
    $properties = ['customers' => $customers];
    return $this->render('MainMenu.twig', $properties);
  }
}