<!-- block withdraw -->
  <h1>Withdraw</h1>

  <p>Account number {{$accountNumber}}, owned by {{$customerName}}
     with number {{$customerNumber}}.</p>
  
  <form method="get" action="/withdrawDone/{{$customerNumber}}/{{$customerName}}/{{$accountNumber}}">
    Name: <input input type="number" step="0.01"
          name="amount" autofocus="autofocus">
    <input type="submit" value="Ok">
  </form>
<!-- endblock -->