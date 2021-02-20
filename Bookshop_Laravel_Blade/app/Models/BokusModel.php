<?php
namespace App\Models;
use DB;

class BokusModel {
  public function search($author, $title) {
    if (($author != null) && ($title != null)) {
      return DB::table("Books")->where("author", "like", "%$author%")->where("title", "like", "%$title%")->get();
    }
    else if ($author != null) {
      return DB::table("Books")->where("author", "like", "%$author%")->get();
    }
    else if ($title != null) {
      return DB::table("Books")->where("title", "like", "%$title%")->get();
    }
    else {
      return DB::table("Books")->get();
    }
  }

  public function add($id, $number) {
    DB::table("Orders")->insert(["id" => $id, "number" => $number]);
  }

  public function clear() {
    DB::table("Orders")->delete();
  }

  public function sum() {
    $orderMap = [];
    
    foreach (DB::table("Orders")->get() as $row) {
      $id = $row->id;
      $number = $row->number;
      
      if (isset($orderMap[$id])) {
        $orderMap[$id] += $number;
      }
      else {
        $orderMap[$id] = $number;
      }
    }

    $orders = [];
    $totalSum = 0;
    foreach ($orderMap as $id => $number) {
      $rows = DB::table("Books")->where("id", $id)->get();
      $row = $rows[0];
      $price = $row->price;
      $sum = $number * $price;
      $order = ["id" => $id, "number" => $number, "author" => $row->author, "title" => $row->title, "price" => $price, "sum" => $sum];
/*      $order = [];
      $order->id = $id;
      $order->number = $number;
      $order->author=  $row->author;
      $order->title = $row->title;
      $order->price = $price;
      $order->sum = $sum;*/
      $orders[] = $order;
      $totalSum += $sum;
    }    

    return ["orders" => $orders, "totalSum" => $totalSum];
  }
}
?>