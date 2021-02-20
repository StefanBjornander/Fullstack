<!-- block addCustomer -->
  <h1>Add Customer</h1>

  {{Form::open(["method" => "get", "url" => "/customerAdded"])}}
    {{Form::label("Name:")}}
    {{Form::text("customerName", null, ["autofocus" => "autofocus"])}}
    {{Form::submit("Ok")}}
  {{Form::close()}}

<!--  <form method="get" action="/customerAdded">
    Name: <input type="text" name="customerName" autofocus="autofocus">
    <input type="submit" value="Ok">
  </form>-->
<!-- endblock -->