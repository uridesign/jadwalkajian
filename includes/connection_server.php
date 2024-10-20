<?php

  $servername = "localhost";
  $username = "u9400583_yusufri";
  $password = "!x/8V.!GRu-:";
  $dbname = "u9400583_jamiyyatul_muslimin";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  date_default_timezone_set('Asia/Jakarta');

?>