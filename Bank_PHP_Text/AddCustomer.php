<?php
  function add_customer($connection) {
    echo <<< _END
      Add Customer<p>

      <form method="post" action="Index.php">
        Name: <input type="text" name="customer_name" autofocus="autofocus">
        <input type="hidden" name="state" value="customer_added">
        <input type="submit" value="Ok">
      </form>
      <hr>
_END;
  }
?>