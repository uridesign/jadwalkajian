<?php
  include('includes/session_check.php');
  include('includes/connection.php');
  
  $page_name = '';

  $query = "SELECT * FROM settings"; 
  $result = mysqli_query($conn, $query) or die ( mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Settings Hijr | Jadwal Kajian</title>

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
        <h1 class="h2 mb-5">Settings Hijriah</h1>
        
        <div class="row pt-5 justify-content-center mt-5">
          <div class="col-md-4">
          <?php
              $status = "";
              if(isset($_POST['new']) && $_POST['new']==1){
                $tuneHijri = $_REQUEST['tuneHijri'];

                $update='update settings set tuneHijri="'.$tuneHijri.'" where 1';

                mysqli_query($conn, $update) or die(mysqli_error($conn));
                $status = "Record Updated Successfully. </br></br>
                <a href='./index.php'>Back to home</a>";
                echo '<p style="color:#FF0000;">'.$status.'</p>';
              } else {
            ?>
            <form class="form" name="form" method="post" action=""> 
              <input type="hidden" name="new" value="1" />
              
              <div class="form-item">
                <label for="tuneHijri">Tune Hijriah</label>
                <div class="field-wrap">
                  <input id="tuneHijri" name="tuneHijri" type="text" value="<?php echo $row['tuneHijri'];?>">
                </div>
              </div>
              <div class="form-item">
                <button type="submit" class="btn button-1">Update</button>
              </div>
            </form>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </main>
</body>
</html>