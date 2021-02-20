<?php

namespace Bank\Controllers;

use Bank\Exceptions\DbException;
use Bank\Exceptions\NotFoundException;
use Bank\Models\BankModel;

class MainMenuController extends AbstractController {
  public function mainMenu() {
    return $this->render("MainMenu.twig", []);
  }
}