<!-- block transfer -->
  <h1>Transfer</h1>

  <p>Transfer from account number {{$fromAccountNumber}}, owned by {{$fromCustomerName}}
     (customer number {{$fromCustomerNumber}}). <p>

  <form method="get" action="/transferDone/{{$fromCustomerNumber}}/{{$fromCustomerName}}/{{$fromAccountNumber}}">
    <table border="0">
      <tr>
        <td>To account:</td> <td><select name="toAccountInfo" autofocus="autofocus">

        @foreach ($accountTextArray as $accountText)
          echo "<option>{{$accountText}}</option>";
        @endforeach

        </select></td>
      </tr>

      <tr>
        <td>Amount:</td> <td><input type="text" name="amount" autofocus="autofocus"></td>
      <tr>
      <tr>
        <td><input style="width:100%" type="submit" value="Ok"></td>
      </tr>
    </table>
  </form>
  <hr>
<!-- endblock -->