<?php
  $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!".mysqli_error());

  mysqli_select_db($conn, "dbprog");
?>