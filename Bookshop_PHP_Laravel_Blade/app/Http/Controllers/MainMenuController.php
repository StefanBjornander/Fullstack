<?php
namespace App\Http\Controllers;
use App\Models\BokusModel;
use Request;

class MainMenuController extends Controller {
  public function mainMenu() {
    return view("MainMenu", []);
  }
  
  public function search() {
    return view("SearchMenu", []);
  }

  public function result() {
    $author = Request::get("author");
    $title = Request::get("title");
    $bokusModel = new BokusModel();
    $books = $bokusModel->search($author, $title);
    return view("ResultMenu", ["books" => $books]);
  }

  public function add() {
    $bokusModel = new BokusModel();
    
    foreach ($_GET as $id => $number) {
      if ($number == "on") {
        $number = 1;
      }
      
      if ($number != 0) {
        $bokusModel->add($id, $number);
      }
    }

    return view("AddedMenu", []);
  }

  public function buy() {
    $bokusModel = new BokusModel();
    $map = $bokusModel->sum();
    return view("BuyMenu", $map);
  }
  
  public function clear() {
    $bokusModel = new BokusModel();
    $bokusModel->clear();
    return view("ClearMenu", []);
  }
}
?>