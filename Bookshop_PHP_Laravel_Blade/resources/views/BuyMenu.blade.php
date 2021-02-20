<style>
  .column {
    width: 20mm;
    align: center;
  }

  .button {
    width: 100%;
  }
</style>

<h1>Buy</h1>

@if (count ($orders) > 0)
  Your books have been sent. <p>

  <table border="1">
    <form method="get" action="/">
      <tr align="left">
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Price</th>
        <th>Number</th>
        <th>Sum</th>
      </tr>      

      @foreach ($orders as $order)
        <tr align="left">
          <td>{{$order["id"]}}</td>
          <td>{{$order["author"]}}</td>
          <td>{{$order["title"]}}</td>
          <td>{{$order["price"]}}</td>
          <td>{{$order["number"]}}</td>
          <td>{{$order["sum"]}}</td>
        </tr>      
      @endforeach

      <tr align="left">
        <th colspan="5">Total Sum</th>
        <th>{{$totalSum}}</th>
      </tr>      
      <tr align="left">
         <td colspan="6"><input class="button" type="submit" value="Main Menu"></td>
      </tr>
    </form>
  </table>
@else
  No books to send <p>

  <form method="get" action="/">
    <input type="submit" value="Main Menu">
  </form>
@endif