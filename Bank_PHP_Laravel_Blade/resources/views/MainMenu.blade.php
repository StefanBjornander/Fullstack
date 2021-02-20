@extends('layout')
@section('content')
  <style>
    .column {
      width: 20mm;
    }

    .button {
      width: 100%;
    }
  </style>

  <table border>
    <tr><td colspan="8">
    <form action="/addCustomer" method="get">
      <input type="submit" style="width:100%" value="Add Customer">
    </form>  
    </td></tr>

    <h1>Bank Laravel</h1>
    
    <!-- In Twig: {% for customer in customers %} -->

    <!-- In Blade: -->
    @foreach ($customers as $customer)
      <tr>
        <!-- In Blade: Arrow, in Twig: Dot -->
        <td><b>{{$customer->customerNumber}}</b></td>
            <td colspan = "2"><b>{{$customer->customerName}}</b></td>
        <td>
          <form method="get" action="/editCustomer/{{$customer->customerNumber}}/{{$customer->customerName}}">
            <input type="submit" style="width:100%" value="Edit">
          </form>
        </td>

        <td>
          <form method="get" action="/removeCustomer/{{$customer->customerNumber}}/{{$customer->customerName}}"
                onsubmit="return confirm('Are you sure you want to remove customer {{$customer->customerName}}?')">
            <input type="submit" style="width:100%" value="Remove">
          </form>
        </td>

        <td colspan="3">
          <form method="get" action="/addAccount/{{$customer->customerNumber}}/{{$customer->customerName}}">
            <input type="submit" style="width:100%" value="Add Account">
          </form>
        </td>
      </tr>

      @foreach ($customer->accounts as $account)
        <tr>
          <td></td>
          <td>{{$account->accountNumber}}</td>
          <td>{{$account->accountBalance}}</td>

          <td class="column">
            <form method="get" action="/deposit/{{$customer->customerNumber}}/{{$customer->customerName}}/{{$account->accountNumber}}">
              <input type="submit" style="width:100%" value="Deposit">
            </form>
          </td>

          <td class="column">
            <form method="get" action="/withdraw/{{$customer->customerNumber}}/{{$customer->customerName}}/{{$account->accountNumber}}">
              <input type="submit" style="width:100%" value="Withdraw">
            </form>
          </td>

          <td class="column">
            <form method="get" action="/transfer/{{$customer->customerNumber}}/{{$customer->customerName}}/{{$account->accountNumber}}">
              <input type="submit" style="width:100%" value="Transfer">
            </form>
          </td>

          <td class="column">
            <form method="get" action="/viewAccount/{{$customer->customerNumber}}/{{$customer->customerName}}/{{$account->accountNumber}}">
              <input type="submit" style="width:100%" value="View">
            </form>
          </td>

          <td class="column">
            <form method="get" action="/removeAccount/{{$customer->customerNumber}}/{{$customer->customerName}}/{{$account->accountNumber}}"
                onsubmit="return confirm('Are you sure you want to remove account {{$account->accountNumber}}?')">
              <input type="submit" style="width:100%" value="Remove">
            </form>
          </td>
        </tr>
      @endforeach
    @endforeach
  </table>
@stop