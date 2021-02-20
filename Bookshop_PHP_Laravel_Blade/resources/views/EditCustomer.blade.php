<!-- block editCustomer -->
  <h1>Edit Customer</h1>

  {{Form::open(["method" => "get", "url" => "/customerEdited/$customerNumber/$customerName"])}}
    {{Form::label("Name:")}}
    {{Form::text("customerName", $customerName, ["autofocus" => "autofocus"])}}
    {{Form::submit("Ok")}}
  {{Form::close()}}

<!--  <form method="get" action="/customerEdited/{{$customerNumber}}/{{$customerName}}">
    Name: <input type="text" name="customerName" value="{{$customerName}}" autofocus="autofocus">
    <input type="submit" value="Ok">
  </form>-->
<!-- endblock -->