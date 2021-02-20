<!-- block viewAccount -->
  <h1>View Account</h1>

  @if (count($accountEvents) > 0)
    <p>The events of account number {{$accountNumber}},
       owned by {{$customerName}} with number {{$customerNumber}}.</p>

    <table border>
      <tr><th>Time</th><th>Amount</th></tr>

      @foreach ($accountEvents as $accountEvent)
        <tr>
          <td>{{$accountEvent->time}}</td><td>{{$accountEvent->amount}}</td>
        </tr>
      @endforeach
      
      <tr>
        <td>Balance</td><td>{{$accountBalance}}</td>
      </tr>
    </table>
  @else
    <p>Account number {{$accountNumber}}, owned by {{$customerName}}
       with number {{$customerNumber}}, has no events.</p>
  @endif
  
  <p/>
  
  <form method="get" action="/">
    <input type="submit" value="Ok">
  </form>
<!-- endblock -->