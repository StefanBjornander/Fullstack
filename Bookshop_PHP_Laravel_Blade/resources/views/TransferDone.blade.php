<!-- block transferDone -->
  <h1>Transfer</h1>

  @if ($amount > 0)
    The amount of {{$amount}} kr has been transfered from account number
    {{$fromAccountNumber}} (owned by {{$fromCustomerName}} with customer number
    {{$fromCustomerNumber}}) to account number {{$toAccountNumber}}
    (owned by {{$toCustomerName}} with customer number {{$toCustomerNumber}}).
  @else
    @php ($negativeAmount = -$amount)

    The amount of {{$negativeAmount}} kr has been transfered from account number
    {{$toAccountNumber}} (owned by {{$toCustomerName}} with customer number
    {{$toCustomerNumber}}) to account number {{$fromAccountNumber}}
    (owned by {{$fromCustomerName}} with customer number {{$fromCustomerNumber}}).
  @endif

  <p>
  <form method="get" action="/">
    <input type="submit" autofocus="autofocus" value="Ok">
  </form>
<!-- endblock -->