<!-- block customerRemoved -->
  <h1>Customer Removed</h1>

  @if ($numberOfAccounts == 0)
    <p>Customer {{$customerName}} with number {{$customerNumber}} has been removed.</p>
  @else
    <p><i>Customer {{$customerName}} with number {{$customerNumber}}
       cannot be removed since they own {{$numberOfAccounts}} accounts.</i></p>
  @endif
  
  <form method="get" action="/">
    <input type="submit" value="Ok">
  </form>
<!-- endblock -->