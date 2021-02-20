<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //CREATE TABLE customers (customerNumber INTEGER AUTO_INCREMENT KEY,
    //            customerName VARCHAR(256));

    Schema::create("customers", function(Blueprint $table) {
      $table->increments("customerNumber"); // integer auto_increment key
      $table->string("customerName", 100);  // varchar
      $table->timestamps();         // created_at, updated_at
    });

    // CREATE TABLE accounts (accountNumber INTEGER AUTO_INCREMENT KEY,
    //            customerNumber INTEGER,
    //            FOREIGN KEY (customerNumber) REFERENCES customers(customerNumber));

    Schema::create("accounts", function(Blueprint $table) {
      $table->increments("accountNumber");
      $table->integer("customerNumber")->unsigned();
      $table->foreign("customerNumber")->references("customerNumber")->on("customers");
      $table->timestamps();
    });

    // CREATE TABLE events (accountNumber INTEGER,
    //            time TIMESTAMP,
    //            amount FLOAT,o
    //            FOREIGN KEY (accountNumber) REFERENCES accounts(accountNumber));

    Schema::create("events", function(Blueprint $table) {
      $table->integer("accountNumber")->unsigned();
      $table->timestamp("time");
      $table->float("amount");
      $table->foreign("accountNumber")->references("accountNumber")->on("accounts");
      $table->timestamps();
    });

    return "Tables Created.";
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("events");
    Schema::dropIfExists("accounts");
    Schema::dropIfExists("customers");
  }
}