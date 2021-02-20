<style>
  .column {
    width: 20mm;
    align: center;
  }

  .button {
    width: 100%;
  }
</style>

<h1>Search</h1>

<table>
  <form method="post" action="/searched">
    <tr>
      <td>Name:</td>
      <td class="column"><input type="text" name="author" autofocus="autofocus"></td>
    </tr>      

    <tr>
      <td>Title:</td>
      <td class="column"><input type="text" name="title"></td>
    </tr>      

    <tr>
      <td colspan="2">  <input class="button" type="submit" value="Search"></td>
    </tr>
  </form>
  
  <form method="post" action="/">
    <tr>
      <td colspan="2">  <input class="button" type="submit" value="Main Menu"></td>
    </tr>
  </form>
</table>
