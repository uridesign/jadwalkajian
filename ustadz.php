<?php
  include('includes/session_check_nologin.php');
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
        <p class="mb-5 text-end"><a class="button-1" href="./input-ustadz.php">+ Tambah Ustadz</a></p>
        <table class="data_list">
          <thead>
            <tr class="dtl-header">
              <th>Nama ustadz</th>  
              <th>Action</th>  
            </tr>
          </thead>
          <tbody>
            <?php 
              if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
            ?>
            
            <tr class="dtl-item">
              <td class="dtl-col">
                <p><strong>Ustadz <?php echo $row['name'];?></strong></p>
                <p><small><em><?php echo $row['caption'];?></em></small></p>
              </td>
              <td class="dtl-action">
                <a class="link-edit" href="./edit-ustadz.php?id=<?php echo $row['id']?>" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                <?php if ( isset($_SESSION["loggedin"]) ) {?>
                  <a class="link-delete" href="./delete-ustadz.php?id=<?php echo $row['id']?>" title="Delete" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fa-regular fa-trash-can" ></i></a>
                <?php } ?>
              </td>
            </tr>

            <?php
                }
              } else {
                echo "<p class='text-center'>0 results</p>";
              }
              $conn->close();
            ?>
          </tbody>
        </div>
      </div>
    </div>
  </main>
</body>
</html>