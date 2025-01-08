<?php
  include('includes/connection.php');
  
  $page_name = 'ustadz';

  $kajian=$_REQUEST['kajian'];

  $query_kajian = "SELECT * FROM ustadz ORDER BY name"; 
  $result = $conn->query($query_kajian);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Manage Ustadz</title>

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
        <h1 class="h2 mb-5">Daftar Ustadz</h1>
        <p class="mb-5"><a href="./input-ustadz.php">Tambah Ustadz</a></p>
        <div class="row">
          <?php 
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
          ?>
            
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 mb-lg-4">
              <div class="kajian_card">
                <div class="top-card">
                  <h2>Ustadz <?php echo $row['name'];?></h2>
                  <h3><?php echo $row['caption'];?></h3>
                </div>
                <div class="bottom-card">
                  <div class="bottom-panel">
                    <a href="./edit-ustadz.php?id=<?php echo $row['id']?>"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a href="./delete-ustadz.php?id=<?php echo $row['id']?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa-regular fa-trash-can" ></i></a>
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