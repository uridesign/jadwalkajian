<?php
  include('includes/connection.php');
  
  $page_name = '';

  $id=$_REQUEST['id'];
  $query = "SELECT * from ustadz where id='".$id."'"; 
  $result = mysqli_query($conn, $query) or die ( mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Input Ustadz | Jadwal Kajian</title>

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
        <h1>Edit Ustadz</h1>
        <div class="row justify-content-center mt-5">
          <div class="col-md-8">
            <?php
              $status = "";
              if(isset($_POST['new']) && $_POST['new']==1){
                $id       = $_REQUEST['id'];
                $name     = $_REQUEST['name'];
                $caption  = $_REQUEST['caption'];

                $update='update ustadz set name="'.$name.'", 
                caption="'.$caption.'" where id="'.$id.'"';

                mysqli_query($conn, $update) or die(mysqli_error($conn));
                $status = "Record Updated Successfully. </br></br>
                <a href='./ustadz.php'>Back to manage ustadz</a>";
                echo '<p style="color:#FF0000;">'.$status.'</p>';
              } else {
            ?>
            <form action="" method="post" class="form">
              <input type="hidden" name="new" value="1" />
              <input name="id" type="hidden" value="<?php echo $row['id'];?>" />

              <div class="row">
                <div class="form-item col-12">
                  <label for="name">Nama Ustadz</label>
                  <div class="field-wrap">
                    <input type="text" name="name" id="name" value="<?php echo $row['name'];?>">
                  </div>
                </div>
                <div class="form-item col-12">
                  <label for="caption">Caption</label>
                  <div class="field-wrap">
                    <textarea type="text" name="caption" id="caption" rows="5"><?php echo $row['caption'];?></textarea>
                  </div>
                </div>
                <div class="form-item col-12 col-md-12 mt-3">
                  <a href="./ustadz.php" class="btn button-1 _bg-danger">Cancel</a>
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