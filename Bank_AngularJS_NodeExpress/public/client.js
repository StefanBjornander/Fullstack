angular.module('BankApp', [])
.controller('MainCtrl', ['$http',
    function($http) {
      var self = this;
      
      self.loadCustomers =
        function() {
          $http.get('/api/customers').then(
            function(response) {
              self.customers = response.data;
              
              self.customers.forEach(
                function(customer) {
                  self.loadAccountsCustomerObject(customer);
                }
              );
            },
            function(response) {
              alert('Error while fetching customers');
            }
          );
        }

      self.loadCustomers();

      self.addCustomer =
        function() {
          self.state = 'add_customer';
          self.customer_add_name = null;
          //document.getElementById("add_input").focus();
        }

      self.customerAdded =
        function() {
          $http.post('/api/add_customer/' + self.customer_add_name).then(
            function(response) {  
              if (response.data) {
                self.customer_number = response.data.number;
                self.state = 'customer_added';
                self.loadCustomers();
              }
            },
            function(response) {
              alert('Error while fetching notes');
            }
          )       
        }
        
      self.editCustomer =
        function(customer_name, customer_number) {
          self.state = 'edit_customer';
          self.customer_name = customer_name;
          self.customer_edit_name = customer_name;
          self.customer_number = customer_number;
          //document.getElementById("edit_input").focus();
        }

      self.customerEdited =
        function() {
          $http.post('/api/edit_customer/' + self.customer_number +
                     '/' + self.customer_edit_name).then(
            function(response) {
              if (response.data) {
                self.state = 'customer_edited';
                self.loadCustomers();
              }
            },
            function(response) {
              alert('Error while fetching notes');
            }
          )
        }
        
      self.onCancel =
        function() {
          self.state = null;
        }

      self.deleteCustomer =
        function(customer_name, customer_number) {
          var message = "Are you sure you want to delete customer " +
                        customer_name + " (customer number " +
                        customer_number + ")?";

          if (confirm(message)) {
            $http.post('/api/delete_customer/' + customer_number).then(
              function(response) {
                self.count = response.data.count;
                self.customer_name = customer_name;
                self.customer_number = customer_number;
                self.state = 'customer_deleted';
                
                if (self.count == 0) {
                  self.loadCustomers();
                }
              },
              function(response) {
                alert('Error while fetching notes');
              }
            );
          }
        }

      self.addAccount =
        function(customer_name, customer_number) {
          $http.post('/api/add_account/' + customer_number).then(
            function(response) {  
              self.customer_name = customer_name;
              self.customer_number = customer_number;                
              self.account_number = response.data.number;
              self.state = 'account_added';
              self.loadAccountsCustomerNumber();
            },
            function(response) {
              alert('Error while fetching notes');
            }
          )       
        }

      self.loadAccountsCustomerNumber =
        function() {
          var customer = self.customers.find(
            function (cust) {
              return (cust.customer_number == self.customer_number);
            }
          );

          self.loadAccountsCustomerObject(customer);
        }
  
      self.loadAccountsCustomerObject =
        function(customer) {
          $http.get('/api/accounts/' + customer.customer_number).then(
            function(response) {
              customer.accounts = response.data;

              customer.accounts.forEach(
                function(account) {
                  $http.get('/api/history/' + account.account_number).then(
                    function(response) {
                      account.balance = response.data.balance;
                    },
                    function(response) {
                      alert('Error while fetching notes');
                    }
                  );
                }
              );
            },
            function(response) {
              alert('Error while fetching notes');
            }
          );
        }

      self.deposit =
        function(customer_name, customer_number, account_number) {
          self.state = 'deposit';
          self.customer_name = customer_name;
          self.customer_number = customer_number;          
          self.account_number = account_number;
          self.amount = null;
          //document.getElementById("deposit_input").focus();
        }
      
      self.depositDone =
        function() {
          if (self.amount > 0) {
            $http.post('/api/deposit/' + self.account_number + '/' + self.amount).then(
              function(response) {
                self.state = 'deposit_done';
                self.loadAccountsCustomerNumber();
              },
              function(response) {
                alert('Error while fetching notes');
              }
            )
          }
          else if (self.amount < 0) {
            self.amount = -self.amount;
            self.withdrawDone();
          }
          else {
            alert("You cannot deposit $0.");
          }
        }

      self.withdraw =
        function(customer_name, customer_number, account_number) {
          self.state = 'withdraw';
          self.customer_name = customer_name;
          self.customer_number = customer_number;          
          self.account_number = account_number;
          self.amount = null;
          //document.getElementById("withdraw_input").focus();
        }

      self.withdrawDone =
        function() {
          if (self.amount > 0) {
            $http.post('/api/withdraw/' + self.account_number + '/' + self.amount).then(
              function(response) {
                self.state = 'withdraw_done';
                self.loadAccountsCustomerNumber();
              },
              function(response) {
                alert('Error while fetching notes');
              }
            )
          }
          else if (self.amount < 0) {
            self.amount = -self.amount;
            self.depositDone();
          }
          else {
            alert("You cannot withdraw $0.");
          }
        }

      self.viewHistory =
        function(customer_name, customer_number, account_number) {
          $http.get('/api/history/' + account_number).then(
            function(response) {
              self.customer_name = customer_name;
              self.customer_number = customer_number;          
              self.account_number = account_number;
              self.history = response.data.history;
              self.balance = response.data.balance;
              self.state = 'view_history';
            },
            function(response) {
              alert('Error while fetching notes');
            }
          )
        }

      self.deleteAccount =
        function(customer_name, customer_number, account_number) {
          var message = "Are you sure you want to delete account " +
                        account_number + ", owned by " + customer_name +
                        " (customer number " + customer_number + ")?";

          if (confirm(message)) {
            $http.post('/api/delete_account/' + account_number).then(
              function(response) {
                self.state = 'account_deleted';
                self.customer_name = customer_name;
                self.customer_number = customer_number;          
                self.account_number = account_number;
                self.balance = response.data.balance;
              
                if (self.balance == 0) {
                  self.loadAccountsCustomerNumber();
                }
              },
              function(response) {
                alert('Error while fetching notes');
              }
            );
          }
        }
    }
  ]
)
.filter('euro_minus_urrency', ["$filter",
    function ($filter) {       
      return function(amount, symbol) {
        var currency = $filter('currency');  
        var euro = "€";
        //var sek = "SEK";

        if(amount >= 0){
          return currency(amount, euro);
        }
        else {
          return ("-" + currency(amount, euro)).replace(/[()]/g, "");
        }
      }
    }
  ]
);