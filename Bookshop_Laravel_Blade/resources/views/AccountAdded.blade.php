<!-- block accountAdded -->
  <h1>Account Added</h1>

  <p>Account number {{$accountNumber}}, owned by {{$customerName}}
     with number {{$customerNumber}}, has been added.</p>

 {{ Form::open(["method" => "get", "url" => "/"])}}
 {{ Form::submit("Ok")}}
 {{ Form::close()}}

<!--  <form method="get" action="/">
    <input type="submit" value="Ok">
  </form>-->
<!-- endblock -->