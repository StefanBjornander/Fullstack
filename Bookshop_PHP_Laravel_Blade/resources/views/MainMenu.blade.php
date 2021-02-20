@extends('layout')
@section('content')
  <style>
    .column {
      width: 20mm;
      align: center;
    }

    .button {
      width: 100%;
    }
  </style>

  <table border>
    <tr>
      <td colspan="4" align="center"><h1>Bookshop</h1></td>
    </tr>

    <tr>
      <td class="column" align="center">
        <form method="get" action="\search">
          <input class="button" type="submit" value="Search">
        </form>
      </td>

      <td class="column" align="center">
        <form method="get" action="\buy">
          <input class="button" type="submit" value="Buy">
        </form>
      </td>

      <td class="column" align="center">
        <form method="get" action="\clear">
          <input class="button" type="submit" value="Clear">
        </form>
      </td>
    </tr>
  </table>
@stop