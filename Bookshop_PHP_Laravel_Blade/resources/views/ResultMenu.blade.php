<style>
  .column {
    width: 20mm;
    align: center;
  }

  .button {
    width: 100%;
  }
</style>

<h1>Result</h1>


<!--<table border="1">
  <form method="get" action="/add">
    <tr align="left">
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Price</th>
      <th>Buy</th>
    </tr>      

    @foreach ($books as $book)
      <tr align="left">
        <td>{{$book->id}}</td>
        <td>{{$book->author}}</td>
        <td>{{$book->title}}</td>
        <td>{{$book->price}}</td>
        <td><input type="checkbox" name="{{$book->id}}"></td>
      </tr>      
    @endforeach

    <tr align="left">
      <td colspan="5"><input class="button" type="submit" value="Add"></td>
    </tr>      
  </form>
  <form method="get" action="/">
    <tr align="left">
       <td colspan="5"><input class="button" type="submit" value="Main Menu"></td>
    </tr>
  </form>
</table> -->

<!--<p>

<table border="1">
  <form method="get" action="/add">
    <tr align="left">
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Price</th>
      <th>Buy</th>
    </tr>      

    @foreach ($books as $book)
      <tr align="left">
        <td>{{$book->id}}</td>
        <td>{{$book->author}}</td>
        <td>{{$book->title}}</td>
        <td>{{$book->price}}</td>
        <td><input type="text" style="text-align:center;" size="1" name="{{$book->id}}" value="0"></td>
      </tr>      
    @endforeach

    <tr align="left">
      <td colspan="5"><input class="button" type="submit" value="Add"></td>
    </tr>      
  </form>
  <form method="get" action="/">
    <tr align="left">
       <td colspan="5"><input class="button" type="submit" value="Main Menu"></td>
    </tr>
  </form>
</table>

<p>

<table border="1">
  <form method="get" action="/add">
    <tr align="left">
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Price</th>
      <th colspan="3">Buy</th>
    </tr>      

    @foreach ($books as $book)
      <tr align="left">
        <td>{{$book->id}}</td>
        <td>{{$book->author}}</td>
        <td>{{$book->title}}</td>
        <td>{{$book->price}}</td>
        <td><button onClick="onMinusText({{$book->id}}); return false">-</button>
            <input type="text" style="text-align:center;" size="1" id="text{{$book->id}}" name="{{$book->id}}" value="0" disabled>
            <button onClick="onPlusText({{$book->id}}); return false">+</button></td>
      </tr>      
    @endforeach

    <tr align="left">
      <td colspan="5"><input class="button" type="submit" value="Add"></td>
    </tr>      
  </form>
  <form method="get" action="/">
    <tr align="left">
       <td colspan="5"><input class="button" type="submit" value="Main Menu"></td>
    </tr>
  </form>
</table>

<script>
  function onMinusText(id) {
    let object = document.getElementById("text" + id);
    let value = parseInt(object.value);

    if (value > 0) {
      object.value = (value - 1).toString();
    }
  }
  
  function onPlusText(id) {
    let object = document.getElementById("text" + id);
    let value = parseInt(object.value);
    object.value = (value + 1).toString();
  }  
</script>

<p>
-->

<table border="1">
  <form method="get" action="/add">
    <tr align="left">
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Price</th>
      <th colspan="3">Buy</th>
    </tr>      

    @foreach ($books as $book)
      <tr align="left">
        <td>{{$book->id}}</td>
        <td>{{$book->author}}</td>
        <td>{{$book->title}}</td>
        <td>{{$book->price}}</td>
        <td><button onClick="onMinusSpan({{$book->id}}); return false">-</button>
            <span align="center" id="span_{{$book->id}}" name="{{$book->id}}" value="0">0</span>
            <input type ="hidden" id="{{$book->id}}" name="{{$book->id}}" value="0">
            <button onClick="onPlusSpan({{$book->id}}); return false">+</button></td>
      </tr>      
    @endforeach

    <tr align="left">
      <td colspan="5"><input class="button" type="submit" value="Add"></td>
    </tr>      
  </form>
  <form method="get" action="/">
    <tr align="left">
       <td colspan="5"><input class="button" type="submit" value="Main Menu"></td>
    </tr>
  </form>
</table>

<script>
  function onMinusSpan(id) {
    let object = document.getElementById("span_" + id);
    let value = parseInt(object.textContent);
    
    if (value > 0) {
      object.textContent = (value - 1).toString();
      document.getElementById(id).value = value - 1;
    }
  }
  
  function onPlusSpan(id) {
    let object = document.getElementById("span_" + id);
    let value = parseInt(object.textContent);
    object.textContent = (value + 1).toString();
    document.getElementById(id).value = value + 1;
  }  
</script>