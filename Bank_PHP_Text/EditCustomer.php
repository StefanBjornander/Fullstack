<?php
  function edit_customer($connection) {   
    $customer_name = $_POST["customer_name"];
    $customer_number = $_POST["customer_number"];
      
    echo <<< _END
      Edit Customer<p>

      <form method="post" action="Index.php">
        Name: <input type="text" name="customer_name" value="$customer_name" autofocus="autofocus">
        <input type="hidden" name="customer_number" value="$customer_number">
        <input type="hidden" name="state" value="customer_edited">
        <input type="submit" value="Ok">
      </form>
      <hr>
_END;
  }
?>