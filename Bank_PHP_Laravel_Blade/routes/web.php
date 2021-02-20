<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
CREATE TABLE Customers (customerNumber INTEGER AUTO_INCREMENT KEY,
                        customerName VARCHAR(256));

CREATE TABLE Accounts (accountNumber INTEGER AUTO_INCREMENT KEY,
                       customerNumber INTEGER,
                       FOREIGN KEY (customerNumber) REFERENCES Customers(customerNumber));

CREATE TABLE Events (accountNumber INTEGER,
                     time TIMESTAMP,
                     amount REAL, -- FLOAT
                     FOREIGN KEY (accountNumber) REFERENCES Accounts(accountNumber));
*/

// Schema::enableForeignKeyConstraints();

/*  $customer = new Customer();
  $customer->customerName = "Adam Bertilsson";
  $customer->save();
  return "Customer added.";*/

Route::get("/", "MainMenuController@customerList");

Route::get("/addCustomer", "CustomerController@addCustomer");

use App\Http\Controllers\CustomerController;

Route::get("/customerAdded", "CustomerController@customerAdded");
/*Route::get("/customerAdded", function () {
    
  $controller = new CustomerController();
  return $controller->customerAdded();
});*/

Route::get("/editCustomer/{customerNumber}/{customerName}",
           "CustomerController@editCustomer")->where("customerNumber", "[0-9]+");
Route::get("/customerEdited/{customerNumber}/{customerName}",
           "CustomerController@customerEdited")->where("customerNumber", "[0-9]+");
Route::get("/removeCustomer/{customerNumber}/{customerName}",
           "CustomerController@removeCustomer")->where("customerNumber", "[0-9]+");
Route::get("/addAccount/{customerNumber}/{customerName}",
           "CustomerController@addAccount")->where("customerNumber", "[0-9]+");

Route::get("/deposit/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@deposit")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/depositDone/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@depositDone")->where("accountNumber", "[0-9]+");
Route::get("/withdraw/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@withdraw")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/withdrawDone/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@withdrawDone")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/transfer/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@transfer")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/transferDone/{fromCustomerNumber}/{fromCustomerName}/{fromAccountNumber}",
           "AccountController@transferDone")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/viewAccount/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@viewAccount")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");
Route::get("/removeAccount/{customerNumber}/{customerName}/{accountNumber}",
           "AccountController@removeAccount")->where("customerNumber", "[0-9]+")->where("accountNumber", "[0-9]+");


/*
Route::get("/", function () {
  $controller = new MainMenuController();
  return $controller->customerList();
});

Route::get("/addCustomer", function () {
  $controller = new CustomerController();
  return $controller->addCustomer();
});

Route::get("/customerAdded", function () {
  $controller = new CustomerController();
  return $controller->customerAdded();
});

Route::get("/editCustomer/{customerNumber}/{customerName}", function () {
  $controller = new CustomerController();
  return $controller->editCustomer();
});

Route::get("/customerEdited/{customerNumber}/{customerName}", function () {
  $controller = new CustomerController();
  return $controller->customerEdited();
});

Route::get("/removeCustomer/{customerNumber}/{customerName}", function () {
  $controller = new CustomerController();
  return $controller->removeCustomer();
});

Route::get("/addAccount/{customerNumber}/{customerName}", function () {
  $controller = new CustomerController();
  return $controller->addAccount();
});

Route::get("/deposit/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->deposit();
});

Route::get("/depositDone/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->depositDone();
});

Route::get("/withdraw/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->withdraw();
});

Route::get("/withdrawDone/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->withdrawDone();
});

Route::get("/transfer/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->transfer();
});

Route::get("/transferDone/{fromCustomerNumber}/{fromCustomerName}/{fromAccountNumber}", function () {
  $controller = new AccountController();
  return $controller->transferDone();
});

Route::get("/viewAccount/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->viewAccount();
});

Route::get("/removeAccount/{customerNumber}/{customerName}/{accountNumber}", function () {
  $controller = new AccountController();
  return $controller->removeAccount();
});
*/

/*Route::get("/", function () {
  $customers = DB::table("customers")->select()->get();
  
  foreach ($customers as $customer) {
    $customer->accounts = DB::table("accounts")->select()->where("customerNumber", "=", $customer->customerNumber)->get();
    $accounts = DB::table("accounts")->select()->where("customerNumber", "=", $customer->customerNumber)->get();
    
    foreach ($accounts as $account) {
      $balance = DB::table("events")->where("accountNumber", "=", $account->accountNumber)->sum("amount");
      $account->accountBalance = $balance;
    }
    
    $customer->accounts = $accounts;
  }

  return view("mainmenu", ["customers" => $customers]);
});*/

Route::get("/about", function () {
  return view("about");
});

Route::get("/contact", function () {
  return view("contact");
});

Route::post('/contact', function() {
  $data = Request::all();
 
  $rules = array(
    'subject' => 'required',
    'message' => 'required'
  );

  $validator = Validator::make($data, $rules);

  if($validator->fails()) {
    return Redirect::to('contact')->withErrors($validator)->withInput();
  }

  $emailcontent = array (
    'subject' => $data['subject'],
    'emailmessage' => $data['message']
  );

/*  global $senderAddress;
  global $receiverAddress;
  global $receiverName;
  $senderAddress = 'info@chasacademy.se';
  $receiverAddress = 'stefan.bjornander@outlook.com';
  //$receiverAddress = 'stefan.bjornander@chasacademy.se';
  $receiverName = 'Stefan Bjornander';
  
  $callback = function($message) {
    global $senderAddress;
    global $receiverAddress;
    global $receiverName;
    echo "senderAddress: $senderAddress<br>receiverAddress: $receiverAddress<br> receiverName: $receiverName<br>";
    $message->subject('Test Laravel');
    //$message->from($senderAddress)->to($receiverAddress, $receiverName)->subject('Test Laravel');
  };
  
  Mail::send('emails.contactemail', $emailcontent, $callback);*/

  Mail::send('emails.contactemail', $emailcontent, function($message) {
    $message->subject('Test Laravel');
  });

  if (Mail::failures()) {
    return 'Try again!';
  }
  else {
    return 'Your message has been sent.';
    //return 'Your message ' . "\"" . $data['subject'] . "\", \"" . $data['message'] . "\" has been sent from " .
    //           $senderAddress . " to " . $receiverAddress . " (" . $receiverName . ").";
  }
  
});