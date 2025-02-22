<?php
  include('includes/session_check_nologin.php');
  include('includes/connection.php');
  
  $page_name = 'lihat_jadwal';

  $kajian=$_REQUEST['kajian'];

  $query_kajian = "SELECT kajian.id, kajian.title, kajian.date, ustadz.name FROM kajian INNER JOIN ustadz ON ustadz.id = kajian.ustadz_id ORDER BY status DESC, date"; 
  $result = $conn->query($query_kajian);

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
        <h1 class="h2 mb-5">List semua kajian</h1>
        <div class="row">
          <?php 
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
          ?>
            
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 mb-lg-4">
              <div class="kajian_card">
                <div class="top-card">
                  <h2><?php echo $row['title'];?></h2>
                  <h3>Ustadz <?php echo $row['name'];?></h2>
                  <p><?php echo date("d-m-Y",strtotime( $row['date'] ));?></p>
                </div>
                <div class="bottom-card">
                  <a href="./broadcast_kajian.php?kajian=<?php echo $row['id']?>" class="btn button-1">Broadcast Kajain</a>
                  <a href="./broadcast_live.php?kajian=<?php echo $row['id']?>" class="btn button-1">Broadcast Live</a>
                  <div class="bottom-panel">
                    <a href="./edit-jadwal.php?id=<?php echo $row['id']?>"><i class="fa-regular fa-pen-to-square"></i></a>
                    <?php if ( isset($_SESSION["loggedin"]) ) {?>
                      <a href="./delete-jadwal.php?id=<?php echo $row['id']?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa-regular fa-trash-can" ></i></a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

          <?php   
              }
            } else {
              echo "<p class='text-center'>0 results</p>";
            }
            $conn->close();
          ?>
        </div>
      </div>
    </div>
  </main>
</body>
</html>