<?php
  include('includes/connection.php');
  
  $page_name = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Jadwal Kajian</title>

  <?php include 'includes/head.php';?>

  <link rel="stylesheet" href="css/fonts/fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="css/fonts/fontawesome/css/solid.min.css">
  <link rel="stylesheet" href="css/fonts/fontawesome/css/regular.min.css">
</head>
<body>
  <header>
    <?php include('includes/header.php'); ?>
  </header>
  <main>
    <div class="py-5">
      <div class="wrapper">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <?php
              $name    = mysqli_real_escape_string($conn, $_REQUEST['name']);
              $caption  = mysqli_real_escape_string($conn, $_REQUEST['caption']);

              $sql = "INSERT INTO ustadz (name, caption ) VALUES ('$name', '$caption')";

              if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
              $conn->close();
            ?>
          </div>
        </div>
        <div class="mt-3">
          <a href="./ustadz.php" class="btn button-1">Back</a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>