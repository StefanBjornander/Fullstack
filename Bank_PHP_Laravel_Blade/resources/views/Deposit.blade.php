<!-- block deposit -->
  <h1>Deposit</h1>

  <p>Account number {{$accountNumber}}, owned by {{$customerName}}
     with number {{$customerNumber}}.</p>

  <form method="get" action="/depositDone/{{$customerNumber}}/{{$customerName}}/{{$accountNumber}}">
    Name: <input input type="number" step="0.01"
          name="amount" autofocus="autofocus">
    <input type="submit" value="Ok">
  </form>
<!-- endblock -->