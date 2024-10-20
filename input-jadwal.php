<?php
  include('includes/connection.php');
  
  $page_name = 'input_jadwal';

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
            <form action="./input-jadwal-store.php" class="form">
              <div class="row">
                <div class="form-item col-12 col-md-6">
                  <label for="date">Date</label>
                  <div class="field-wrap">
                    <input type="text" name="date" id="date" class="datepicker">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="time">Ba'da Sholat</label>
                  <div class="field-wrap">
                    <select name="time" id="time">
                      <option value="">- Lewati jika menggunakan jam -</option>
                      <option value="Subuh">Ba'da Sholat Subuh</option>
                      <option value="Dzuhur">Ba'da Sholat Dzuhur</option>
                      <option value="Ashar">Ba'da Sholat Ashar</option>
                      <option value="Maghrib">Ba'da Sholat Maghrib</option>
                      <option value="Isya">Ba'da Sholat Isya</option>
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="title">Judul Kajian</label>
                  <div class="field-wrap">
                    <input type="text" name="title" id="title">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="episode">Episode</label>
                  <div class="field-wrap">
                    <input type="text" name="episode" id="episode" value="1">
                  </div>
                </div>
                <div class="form-item col-12 col-md-6">
                  <label for="book">Nama Kitab</label>
                  <div class="field-wrap">
                    <select name="book" id="book">
                      <option value="">- Pilih -</option>
                      <?php
                        $query_kitab = "SELECT * FROM kitab"; 
                        $result = $conn->query($query_kitab);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while($row_kitab = $result->fetch_assoc()) {
                            echo '<option value="'. $row_kitab['id'] .'">'. $row_kitab['name'] .'</option>';
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
                        $query_ustadz = "SELECT * FROM ustadz"; 
                        $result = $conn->query($query_ustadz);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while($row_ustadz = $result->fetch_assoc()) {
                            echo '<option value="'. $row_ustadz['id'] .'">'. $row_ustadz['name'] .'</option>';
                          }
                        }
                      ?>
                      
                    </select>
                  </div>
                </div>
                <div class="form-item col-12 col-md-12">
                  <label for="link">Link Kajian</label>
                  <div class="field-wrap">
                    <input type="text" name="link" id="link">
                  </div>
                </div>
                <div class="form-item col-12 col-md-12 mt-3">
                  <button class="btn button-1" type="submit">Submit</button>
                </div>
              </div>
            </form>
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