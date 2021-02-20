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
  database: "bank_angularjs"
});

app.use(function (request, response, next) {
  response.header("Access-Control-Allow-Origin", "*");
  response.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

router.get('/customers',
  function(request, result) {
    var sql_query = "SELECT * FROM customer";

    connection.query(sql_query,
      function (err, res, fields) {
        if (err) throw err;
        console.log(res);
        result.send(res);
      }
    );
  }
);

router.get('/accounts/:id',
  function(request, result) {
    var customer_number = request.params.id;//.substring(1);
    var sql_query = "SELECT * FROM account WHERE customer_number = ?";

    connection.query(sql_query, [customer_number],
      function (err, res, fields) {
        if (err) throw err;
        result.send(res);
      }
    );
  }
);

router.post('/add_customer/:id',
  function(request, result) {
    var customer_name = request.params.id;
    
    var connection = mysql.createConnection({
      host: "localhost",
      user: "root",
      password: "",
      database: "bank"
    });

    var sql_query = "INSERT INTO customer (customer_name) VALUES(?)";

    connection.query(sql_query, [customer_name],
      function (err, res, fields) {
        if (err) throw err;
        customer_number = res.insertId;
        result.send({number: customer_number});
      }
    );
  }
);

router.post('/edit_customer/:id1/:id2',
  function(request, result) {
    var customer_number = request.params.id1,
        customer_new_name = request.params.id2;
    var sql_query = "UPDATE customer SET customer_name = ? WHERE customer_number = ?";

    connection.query(sql_query, [customer_new_name, customer_number],
      function (err, res, fields) {
        if (err) throw err;
        var customers = [];
        result.send(true);
      }
    );
  }
);

router.delete('/delete_customer/:id',
  function(request, result) {
    var customer_number = request.params.id;
    var sql_query = "SELECT COUNT(*) FROM account WHERE customer_number = ?";

    connection.query(sql_query, [customer_number],
      function (err, res, fields) {
        if (err) throw err;            
        var count = res[0]['COUNT(*)'];

        if (count == 0) {
          var sql_query = "DELETE FROM customer WHERE customer_number = ?";

          connection.query(sql_query, [customer_number],
            function (err, res, fields) {
              if (err) throw err;
            }
          );
        }

        result.send({count: count});
      }
    );
  }
);

router.post('/add_account/:id',
  function(request, result) {
    var customer_number = request.params.id;
    console.log(customer_number);
    
    var sql_query = "INSERT INTO account (customer_number) VALUES(?)";

    connection.query(sql_query, [customer_number],
      function (err, res, fields) {
        if (err) throw err;
        customer_number = res.insertId;
        result.send({number: customer_number});
      }
    );
  }
);

router.get('/history/:id',
  function(request, result) {
    var account_number = request.params.id;//.substring(1);
    var sql_query = "SELECT * FROM history WHERE account_number = ?";

    connection.query(sql_query, [account_number],
      function (err, res, fields) {
        if (err) throw err;
        var history = res;

        /*history.forEach(
          function(row) {
            var event = JSON.stringify(row.time).replace(/\"/g, "");
            row.time = event.replace("T", " ").replace(".000Z", "");
          }
        );*/

        var sql_query = "SELECT SUM(amount) FROM history WHERE account_number = ?";

        connection.query(sql_query, [account_number],
          function (err, res, fields) {
            if (err) throw err;
            var balance = res[0]['SUM(amount)'];

            if (balance == null) {
              balance = 0;
            }

            result.send({history: history, balance: balance});
          }
        );
      }
    );
  }
);

router.post('/deposit/:id1/:id2',
  function(request, result) {
    var account_number = request.params.id1,
        amount = request.params.id2;

    var sql_query = "INSERT INTO history (account_number, amount) VALUES(?,?)";

    connection.query(sql_query, [account_number, amount],
      function (err, res, fields) {
        if (err) throw err;
        result.send();
      }
    );
  }
);

router.post('/withdraw/:id1/:id2',
  function(request, result) {
    var account_number = request.params.id1,
        amount = request.params.id2;

    var negative_amount = -amount;
    var sql_query = "INSERT INTO history (account_number, amount) VALUES(?,?)";

    connection.query(sql_query, [account_number, negative_amount],
      function (err, res, fields) {
        if (err) throw err;
        result.send();
      }
    );
  }
);

router.delete('/delete_account/:id',
  function(request, result) {
    var account_number = request.params.id;
    var sql_query = "SELECT SUM(amount) FROM history WHERE account_number = ?";

    connection.query(sql_query, [account_number],
      function (err, res, fields) {
        if (err) throw err;            
        var balance = res[0]['SUM(amount)'];

        if (balance == null) {
          balance = 0;
        }

        if (balance == 0) {
          var sql_query = "DELETE FROM history WHERE account_number = " +
                          account_number;

          connection.query(sql_query,
            function (err, res, fields) {
              if (err) throw err;

              var sql_query = "DELETE FROM account WHERE account_number = " +
                              account_number;
              connection.query(sql_query,
                function (err, res, fields) {
                  if (err) throw err;
                }
              );
            }
          );
        }

        result.send({balance: balance});
      }
    );
  }
);

// ------------------------

router.get('/accounts/:id',
  function(request, result) {
    var customer_number = request.params.id;//.substring(1);

    result.send(
      accounts.filter(
        function (account) {
          return (account.customer_number == customer_number);
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
  var customer_number = request.params.id;//.substring(1);

  result.send(
    accounts.filter(
      function (account) {
        return (account.customer_number == customer_number);
      }
    )
  );
  
  result.send({message: 'Customer number <' + customer_number + '> not found'}, 404);
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