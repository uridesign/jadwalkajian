<?php
  include('includes/session_check.php');
  include('includes/connection.php');
  
  $page_name = '';

  $id=$_REQUEST['id'];
  $query = "SELECT * from kajian where id='".$id."'"; 
  $result = mysqli_query($conn, $query) or die ( mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Input Jadwal - Jadwal Kajian</title>

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
        <h1>Input Jadwal</h1>
        <div class="row justify-content-center mt-5">
          <div class="col-md-8">
            <?php
              $status = "";
              if(isset($_POST['new']) && $_POST['new']==1){
                $id       = $_REQUEST['id'];
                $date     = $_REQUEST['date'];
                $time     = $_REQUEST['time'];
                $title    = $_REQUEST['title'];
                $episode  = $_REQUEST['episode'];
                $link     = $_REQUEST['link'];
                $status   = $_REQUEST['status'];
                $name     = $_REQUEST['name'];
                $book     = $_REQUEST['book'];

                $update='update kajian set date="'.$date.'", 
                sholat="'.$time.'",
                title="'.$title.'", 
                episode="'.$episode.'",
                link="'.$link.'",
                status="'.$status.'",
                ustadz_id="'.$name.'",
                kitab_id="'.$book.'" where id="'.$id.'"';

                mysqli_query($conn, $update) or die(mysqli_error($conn));
                $status = "Record Updated Successfully. </br></br>
                <a href='./index.php'>Back to home</a>";
                echo '<p style="color:#FF0000;">'.$status.'</p>';
              } else {
            ?>
            <form action="" method="post" class="form">
              <input type="hidden" name="new" value="1" />
              <input name="id" type="hidden" value="<?php echo $row['id'];?>" />

              <div class="row">
                <div class="form-item col-12 col-md-6">
                  <label for="date">Date</label>
                  <div class="field-wrap">
                    <input type="text" name="date" id="date" class="datepicker" value="<?php echo $row['date'];?>">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="time">Ba'da Sholat</label>
                  <div class="field-wrap">
                    <select name="time" id="time">
                      <option value="">- Lewati jika menggunakan jam -</option>
                      <option value="Subuh" <?php echo ( $row['sholat'] == 'Subuh' ) ? 'selected' : '' ;?>>Ba'da Sholat Subuh</option>
                      <option value="Dzuhur" <?php echo ( $row['sholat'] == 'Dzuhur' ) ? 'selected' : '' ;?>>Ba'da Sholat Dzuhur</option>
                      <option value="Ashar" <?php echo ( $row['sholat'] == 'Ashar' ) ? 'selected' : '' ;?>>Ba'da Sholat Ashar</option>
                      <option value="Maghrib" <?php echo ( $row['sholat'] == 'Maghrib' ) ? 'selected' : '' ;?>>Ba'da Sholat Maghrib</option>
                      <option value="Isya" <?php echo ( $row['sholat'] == 'Isya' ) ? 'selected' : '' ;?>>Ba'da Sholat Isya</option>
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="title">Judul Kajian</label>
                  <div class="field-wrap">
                    <input type="text" name="title" id="title" value="<?php echo $row['title'];?>">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="episode">Episode</label>
                  <div class="field-wrap">
                    <input type="text" name="episode" id="episode" value="<?php echo $row['episode'];?>">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="book">Nama Kitab</label>
                  <div class="field-wrap">
                    <select name="book" id="book">
                      <option value="">- Pilih -</option>
                      <?php
                        $kitab_id = $row['kitab_id'];
                        $query_kitab = "SELECT * FROM kitab"; 
                        $result = $conn->query($query_kitab);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while($row_kitab = $result->fetch_assoc()) {
                            $selected = ( $row_kitab['id'] == $kitab_id ) ? 'selected' : '';
                            echo '<option value="'. $row_kitab['id'] .'" '. $selected .'>'. $row_kitab['name'] .'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="name">Nama Ustadz</label>
                  <div class="field-wrap">
                    <select name="name" id="name">
                      <option value="">- Pilih -</option>
                      <?php
                        $ustadz_id = $row['ustadz_id'];
                        $query_ustadz = "SELECT * FROM ustadz"; 
                        $result = $conn->query($query_ustadz);
                        if ($result->num_rows > 0) {
                          while($row_ustadz = $result->fetch_assoc()) {
                            $selected = ( $row_ustadz['id'] == $ustadz_id ) ? 'selected' : '';
                            echo '<option value="'. $row_ustadz['id'] .'" '. $selected .'>'. $row_ustadz['name'] .'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="link">Link Kajian</label>
                  <div class="field-wrap">
                    <input type="text" name="link" id="link" value="<?php echo $row['link'];?>">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="status">Status</label>
                  <div class="field-wrap">
                    <select name="status" id="status">
                      <option value="0">Inactive</option>
                      <option value="1" <?php echo ($row['status']) ? 'selected' : '';?>>Active</option>
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-12 mt-3">
                  <button class="btn button-1" type="submit">Submit</button>
                </div>
              </div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
<!-- Datepicker -->
<link rel="stylesheet" href="js/datepicker/bootstrap.css">
<script src="js/datepicker/bootstrap.min.js"></script>
<link rel="stylesheet" href="js/datepicker/bootstrap-datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="js/datepicker/bootstrap-datetimepicker.min.js"></script>

<script>
  $(function () {
    var d = new Date();
    d.setHours(d.getHours(), 0, 0);
    $('.datepicker').datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      defaultDate: d,
      icons: {
        time: 'far fa-clock'
      }
    });
  });
</script>
</html>