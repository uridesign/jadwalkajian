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
              $date     = mysqli_real_escape_string($conn, $_REQUEST['date']);
              $time     = mysqli_real_escape_string($conn, $_REQUEST['time']);
              $title    = mysqli_real_escape_string($conn, $_REQUEST['title']);
              $episode  = mysqli_real_escape_string($conn, $_REQUEST['episode']);
              $book     = mysqli_real_escape_string($conn, $_REQUEST['book']);
              $name     = mysqli_real_escape_string($conn, $_REQUEST['name']);
              $link     = mysqli_real_escape_string($conn, $_REQUEST['link']);

              $sql = "INSERT INTO kajian (date, sholat, title, episode, link, status, masjid_id, ustadz_id, kitab_id ) VALUES ('$date', '$time', '$title', '$episode', '$link', 1, 1, $name, $book)";

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
          <a href="./index.php" class="btn button-1">Back</a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>