<?php

  require('includes/connection.php');

  $id=$_REQUEST['id'];
  $query = "DELETE FROM ustadz WHERE id=$id"; 
  $result = mysqli_query($conn,$query) or die ( mysqli_error($conn));
  header("Location: ustadz.php"); 
  
?>