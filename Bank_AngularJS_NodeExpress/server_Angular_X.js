// server.js (Express 4.0)
var express        = require('express');
var morgan         = require('morgan');
var bodyParser     = require('body-parser');
var methodOverride = require('method-override');
var app            = express();

app.use(express.static(__dirname + '/public')); // set the static files location /public/img will be /img for users
app.use(morgan('dev')); 			// log every request to the console
app.use(bodyParser()); 				// pull information from html in POST
app.use(methodOverride()); 			// simulate DELETE and PUT

var router = express.Router();
var mysql = require('mysql');

var connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "BankAngular"
});

app.use(function (request, response, next) {
  response.header("Access-Control-Allow-Origin", "*");
  response.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

router.get('/customers',
  function(request, result) {
    var sqlQuery = "SELECT * FROM customer";

    connection.query(sqlQuery,
      function (err, res, fields) {
        if (err) throw err;
        result.send(res);
      }
    );
  }
);

router.get('/accounts/:id',
  function(request, result) {
    var customerNumber = request.params.id;//.substring(1);
    var sqlQuery = "SELECT * FROM account WHERE customerNumber = ?";

    connection.query(sqlQuery, [customerNumber],
      function (err, res, fields) {
        if (err) throw err;
        result.send(res);
      }
    );
  }
);

router.post('/add_customer/:id',
  function(request, result) {
    var customerName = request.params.id;
    var sqlQuery = "INSERT INTO customer (customerName) VALUES(?)";

    connection.query(sqlQuery, [customerName],
      function (err, res, fields) {
        if (err) throw err;
        customerNumber = res.insertId;
        result.send({customerNumber: customerNumber});
      }
    );
  }
);

router.post('/edit_customer/:id1/:id2',
  function(request, result) {
    var customerNumber = request.params.id1,
        customerName = request.params.id2;
    var sqlQuery = "UPDATE customer SET customerName = ? WHERE customerNumber = ?";

    connection.query(sqlQuery, [customerName, customerNumber],
      function (err, res, fields) {
        if (err) throw err;
        result.send(true);
      }
    );
  }
);

router.post('/delete_customer/:id',
  function(request, result) {
    var customerNumber = request.params.id;
    var sqlQuery = "SELECT SUM(balance) FROM account WHERE customerNumber = ?";

    connection.query(sqlQuery, [customerNumber],
      function (err, res, fields) {
        if (err) throw err;            
        var balance = res[0]['SUM(balance)'];

        if (balance == null) {
          balance = 0;
        }

        if (balance == 0) {
          var sqlQuery = "DELETE FROM history WHERE accountNumber in " +
                         "(SELECT accountNumber FROM account WHERE customerNumber = ?)";

          connection.query(sqlQuery, [customerNumber],
            function (err, res, fields) {
              if (err) throw err;
              var sqlQuery = "DELETE FROM account WHERE customerNumber = ?";

              connection.query(sqlQuery, [customerNumber],
                function (err, res, fields) {
                  if (err) throw err;
                  var sqlQuery = "DELETE FROM customer WHERE customerNumber = ?";

                  connection.query(sqlQuery, [customerNumber],
                    function (err, res, fields) {
                      if (err) throw err;
                      result.send({balance: balance});
                    }
                  );
                }
              );
            }
          );
        }
        else {
          result.send({balance: balance});
        }
      }
    );
  }
);

router.post('/add_account/:id',
  function(request, result) {
    var customerNumber = request.params.id;
    
    var sqlQuery = "INSERT INTO account (customerNumber) VALUES(?)";

    connection.query(sqlQuery, [customerNumber],
      function (err, res, fields) {
        if (err) throw err;
        accountNumber = res.insertId;
        result.send({accountNumber: accountNumber});
      }
    );
  }
);

router.get('/history/:id',
  function(request, result) {
    var accountNumber = request.params.id;//.substring(1);
    var sqlQuery = "SELECT * FROM history WHERE accountNumber = ?";

    connection.query(sqlQuery, [accountNumber],
      function (err, res, fields) {
        if (err) throw err;
        result.send(res);
      }
    );
  }
);

router.post('/deposit/:id1/:id2',
  function(request, result) {
    var accountNumber = request.params.id1,
        amount = request.params.id2;
    var sqlQuery = "INSERT INTO history(accountNumber, amount) VALUES(?,?)";

    connection.query(sqlQuery, [accountNumber, amount],
      function (err, res, fields) {
        if (err) throw err;
        var sqlQuery = "UPDATE account SET balance = balance + ? WHERE accountNumber = ?";

        connection.query(sqlQuery, [amount, accountNumber],
          function (err, res, fields) {
            if (err) throw err;
            result.send();
          }
        );
      }
    );
  }
);

router.post('/withdraw/:id1/:id2',
  function(request, result) {
    var accountNumber = request.params.id1,
        amount = request.params.id2;

    var negativeAmount = -amount;
    var sqlQuery = "INSERT INTO history (accountNumber, amount) VALUES(?,?)";

    connection.query(sqlQuery, [accountNumber, negativeAmount],
      function (err, res, fields) {
        if (err) throw err;
        var sqlQuery = "UPDATE account SET balance = balance - ? WHERE accountNumber = ?";

        connection.query(sqlQuery, [amount, accountNumber],
          function (err, res, fields) {
            if (err) throw err;
            result.send();
          }
        );
      }
    );
  }
);

router.post('/delete_account/:id',
  function(request, result) {
    var accountNumber = request.params.id;
    var sqlQuery = "SELECT balance FROM account WHERE accountNumber = ?";

    connection.query(sqlQuery, [accountNumber],
      function (err, res, fields) {
        if (err) throw err;
        var balance = res[0]['balance'];

        if (balance == null) {
          balance = 0;
        }

        if (balance == 0) {
          var sqlQuery = "DELETE FROM history WHERE accountNumber = ?";

          connection.query(sqlQuery, [accountNumber],
            function (err, res, fields) {
              if (err) throw err;

              var sqlQuery = "DELETE FROM account WHERE accountNumber = ?";
              connection.query(sqlQuery, [accountNumber],
                function (err, res, fields) {
                  if (err) throw err;
                  result.send({balance: balance});
                }
              );
            }
          );
        }
        else {
          result.send({balance: balance});
        }
      }
    );
  }
);

// ------------------------

router.get('/accounts/:id',
  function(request, result) {
    var customerNumber = request.params.id;//.substring(1);

    result.send(
      accounts.filter(
        function (account) {
          return (account.customerNumber == customerNumber);
        }
      )
    );
  }
);

router.post('/note', function(request, result) {
  var note = request.body;
  note.id = lastId;
  lastId++;
  notes.push(note);
  result.send(note);
});

router.post('/note/:id/done', function(request, result) {
  var noteId = request.params.id;
  var note = null;
  for (var i = 0; i < notes.length; i++) {
    if (notes[i].id == request.params.id) {
      note = notes[i];
      break;
    }
  }
  note.label = 'Done - ' + note.label;
  result.send(notes);
});

router.get('/note/:id', function(request, result) {
  var customerNumber = request.params.id;//.substring(1);

  result.send(
    accounts.filter(
      function (account) {
        return (account.customerNumber == customerNumber);
      }
    )
  );
  
  result.send({message: 'Customer number <' + customerNumber + '> not found'}, 404);
});

router.post('/note/:id', function(request, result) {
  for (var i = 0; i < notes.length; i++) {
    if (notes[i].id == request.params.id) {
      notes[i] = request.body;
      notes[i].id = request.params.id;
      result.send(notes[i]);
      break;
    }
  }
  result.send({msg: 'Note not found'}, 404);
});

router.post('/login', function(request, result) {
  //console.log('API LOGIN FOR ', request.body);
  result.send({msg: 'Login successful for ' + request.body.username});
});

app.use('/api', router);
app.listen(3000);
console.log('Open http://localhost:3000 to access the files now'); 			// shoutout to the user