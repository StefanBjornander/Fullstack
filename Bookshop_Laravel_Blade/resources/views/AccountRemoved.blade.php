<!-- block accountRemoved -->
  <h1>Account Removed</h1>

  @if ($accountBalance == 0)
    <p>Account number {{$accountNumber}}, owned by {{$customerName}}
       with number {{$customerNumber}}, has been removed.</p>
  @else
    <p><i>Account number {{$accountNumber}}, owned by {{$customerName}} with number
       {{$customerNumber}}, cound not be removed since its account accountBalance
       does not equal zero (the account accountBalance equals {{$accountBalance}} kr).</i></p>
  @endif

  <form method="get" action="/">
    <input type="submit" value="Ok">
  </form>
<!-- endblock -->