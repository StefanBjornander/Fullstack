import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Customer } from './model/customer';
import { Account } from './model/account';
import { History } from './model/history';
import { BankService } from './services/bank.service';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
@Injectable()
export class AppComponent implements OnInit {
  constructor(private bankService: BankService, private http: HttpClient) {}

  title = 'Bank';
  public state = '';
  public message = '';

//---------------------------------------------

  public oldCustomerName;
  public newCustomerName;
  public customer_number;
  public customer;
  public account;
  public history;
  public amount;

  addCustomer() {
    alert("Hello");
    this.newCustomerName = '';
    this.state = 'AddCustomer';
  }

  customerAdded() {
    var self = this;

    this.http.post('http://localhost:3000/api/add_customer/' + this.newCustomerName, "").subscribe((result) => {
      self.message = this.newCustomerName + " with customer number " + result['customer_number'] + " has been added.";
      self.state = '';
      self.loadCustomerArray();
    });
  }

//---------------------------------------------

  editCustomer(customer) {
    this.customer_number = customer.customer_number;
    this.oldCustomerName = customer.customer_name;
    this.newCustomerName = customer.customer_name;
    this.state = 'EditCustomer';
  }

  customerEdited() {
    var self = this;
    this.http.post('http://localhost:3000/api/edit_customer/' + this.customer_number + "/" +
                   this.newCustomerName, "").subscribe((result) => {
      self.message = this.oldCustomerName + ", with customer number " + this.customer_number
                     + ", has been changed to " + this.newCustomerName + ".";
      self.state = '';
      self.loadCustomerArray();
    });
  }

//---------------------------------------------

  deleteCustomer(customer) {
    this.message = '';
    var warning = "Are you sure you want to delete customer " + customer.customer_name +
                  " with customer number " + customer.customer_number + "?";

    if (confirm(warning)) {
      this.http.post('http://localhost:3000/api/delete_customer/' + customer.customer_number, "").subscribe((result) => {
        var count = result['count'];

        if (count == 0) {
          this.message = customer.customer_name + ", with customer number " +
                         customer.customer_number + ", has been deleted.";
        }
        else {
          this.message = customer.customer_name + ", with customer number " +
                         customer.customer_number + ", could not be deleted since they have accounts."
        }

        this.state = '';
        this.loadCustomerArray();
      });
    }
  }

//---------------------------------------------

  addAccount(customer) {
    var self = this;
    this.http.post('http://localhost:3000/api/add_account/' + customer.customer_number, "").subscribe((result) => {
      self.message = "An account with number " + result['account_number'] + " has been added to customer " +
                     customer.customer_name + " with customer number " + customer.customer_number + ".";
      self.state = '';
      self.loadCustomerArray();
    });
  }

//---------------------------------------------

  deposit(customer, account) {
    this.customer = customer;
    this.account = account;
    this.amount = null;
    this.state = "Deposit";
  }

  depositDone() {
    var self = this;
    this.http.post('http://localhost:3000/api/deposit/' + this.account.account_number +
                   '/' + this.amount, "").subscribe((result) => {
      self.message = "Account number " + this.account.account_number +
                      ", belonging to " + this.customer.customer_name + " with customer number " +
                      this.customer.customer_number + ", has been deposit with " + this.amount + " kr.";
      self.state = '';
      self.loadCustomerArray();
    });
  }

//---------------------------------------------

  withdraw(customer, account) {
    this.customer = customer;
    this.account = account;
    this.amount = 0;
    this.state = "Withdraw";
  }

  withdrawDone() {
    var self = this;
    this.http.post('http://localhost:3000/api/withdraw/' + this.account.account_number +
                   '/' + this.amount, "").subscribe((result) => {
      self.message = "Account number " + this.account.account_number +
                      ", belonging to " + this.customer.customer_name + " with customer number " +
                      this.customer.customer_number + ", has been withdrawn with " + this.amount + " kr.";
      self.state = '';
      self.loadCustomerArray();
    });
  }

  deleteAccount(customer, account) {
    var self = this;
    var warning = "Are you sure you want to delete account number " + account.account_number +
                  ", belonging to " + customer.customer_name + " with customer number " +
                  customer.customer_number + "?";

    if (confirm(warning)) {
      this.http.post('http://localhost:3000/api/delete_account/' + account.account_number, "").subscribe((result) => {
        var balance = result['balance'];

        if (balance == 0) {
          self.message = "Account number " + account.account_number +
                         ", belonging to " + customer.customer_name + " with customer number " +
                         customer.customer_number + ", has been deleted.";
        }
        else {
          self.message = "Account number " + account.account_number +
                         ", belonging to " + customer.customer_name + " with customer number " +
                         customer.customer_number + ", could not be deleted since its balance is non-zero.";
        }

        self.state = '';
        self.loadCustomerArray();
      });
    }
  }

  ngOnInit(): void {
    this.loadCustomerArray();
  }

  public count;
  public customerArray;
  public accountArrayMap;

  loadCustomerArray() {
    var self = this;
    this.count = 1;
    this.customerArray = []
    this.accountArrayMap = [];

    self.http.get('http://localhost:3000/api/customers').subscribe(value => {
      self.customerArray = value;
      self.count = self.customerArray.length;

      self.customerArray.forEach(function (customer) {
        var customer_number = customer['customer_number'];

        self.http.get<any[]>('http://localhost:3000/api/accounts/' + customer_number).subscribe(accountList => {
          //self.accountArrayMap[customer_number] = accountList;

          var accountBalanceList = [];
          self.accountArrayMap[customer_number] = accountBalanceList;

          accountList.forEach(function (accountRecord) {
            var account_number = accountRecord['account_number'];
            self.http.get('http://localhost:3000/api/balance/' + account_number).subscribe(balanceRecord => {
              var balance = balanceRecord['balance'];
              accountBalanceList.push({account_number: account_number, account_balance: balance});
              console.log(account_number, accountBalanceList);
            });
          });

          --self.count;
        });
      });
    });
  }

  viewHistory(customer, account) {
    var self = this;
    this.customer = customer;
    this.account = account;

    self.http.get('http://localhost:3000/api/history/' + account.account_number).
    subscribe(result => {
      self.history = result;
      self.state = "ViewHistory";
    });
  }
}
