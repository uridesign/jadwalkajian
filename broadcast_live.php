<?php
  include('includes/connection.php');
  
  $page_name = 'lihat_jadwal';

  $kajian=$_REQUEST['kajian'];

  $query_kajian = "SELECT kajian.title AS kajian_title, kajian.episode, kajian.date, kajian.sholat, kajian.link, ustadz.name AS ustadz_name, kitab.name AS kitab_name, masjid.name AS masjid_name, masjid.detail FROM kajian INNER JOIN kitab ON kitab.id = kajian.kitab_id INNER JOIN ustadz ON ustadz.id = kajian.ustadz_id INNER JOIN masjid ON masjid.id = kajian.masjid_id WHERE kajian.id='".$kajian."'"; 
  $result_kajian = mysqli_query($conn, $query_kajian) or die ( mysqli_error($conn));
  $row_kajian = mysqli_fetch_assoc($result_kajian);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Jadwal Kajian <?php echo $row_kajian['date']?></title>

  <?php include 'includes/head.php';?>
</head>
<body>
  <header>
    <?php include('includes/header.php'); ?>
  </header>
  <main>
    <div class="wrapper">

      <div class="pt-t mt-5">
        <a href="./">Back to list</a>
      </div>
      
      <div class="hidden-area">
        <?php
          $data_settings = mysqli_query($conn,"SELECT * FROM settings");
          while($row = mysqli_fetch_array($data_settings)){
            echo '<div id="tuneHijri">' . $row['tuneHijri'] . '</div>';
          }
        ?>
        <div id="episode"><?php echo $row_kajian['episode'];?></div>
        <div id="time"><?php echo $row_kajian['sholat'];?></div>
        <div id="stream_link"><?php echo $row_kajian['link'];?></div>
      </div>

      <div class="row justify-content-center py-5">
        <div class="col col-md-10">
          <h1><span id="title"><?php echo $row_kajian['kajian_title'];?></span></h1>
          <?php if( $row_kajian['episode'] > 1) echo '<p>Episode : '. $row_kajian['episode'] .'</p>' ?>
          <h2 class="h5" style="font-weight: 500"><span id="book"><?php echo 'Kajian ' . $row_kajian['kitab_name']?></span></h2>
          <h3 class="h2" style="font-weight: 600">Ustadz <span id="name"><?php echo $row_kajian['ustadz_name']?></span> حفظه الله</h3>
          <p><span id="date"><?php echo $row_kajian['date']?></span></p>

          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="">Preview Whatsapp</label>
                <textarea name="code" id="code" class="preview"></textarea>
              </div>
              <div>
                <a href="javascript:;" id="copy" class="btn button-1">Copy to WhatsApp</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="report_message"></div>

    </div>
    
  </main>
</body>
<script src="js/moment-locale.min.js"></script>
<script src="js/moment-hijri.js"></script>
<script>
  $(document).ready(function(){

    var hijriAdjust = parseInt($('#tuneHijri').text());

    var title = $('#title').text().toUpperCase();
    var episode = $('#episode').text();
    var book = $('#book').text();
    var name = $('#name').text();
    var date = $('#date').text();
    var time = $('#time').text();
    var stream_link = $('#stream_link').text();

    if ( episode > 1 ) {
      episode = ' [Ep.'+ episode +']';
    } else {
      episode = '';
    }

    moment.locale('id',{
      weekdays : "Ahad_Senin_Selasa_Rabu_Kamis_Jum'at_Sabtu".split('_')
    });

    var day_selected = moment(date, 'YYYY/MM/DD hh:mm');

    var day_name = day_selected.format('dddd');
    var date_selected = day_selected.format('DD MMMM YYYY');
    var date_selected_name = day_selected.format('DD MMMM YYYY');

    if(time == '') {
      time = day_selected.format('kk:mm') + ' WIB';
    } else {
      time = "Ba'da Sholat " + time;
    }

    var hj = moment(date).add(hijriAdjust, 'd').format('iD iMMMM iYYYY');

    var copy_text = '🔰 - Masjid Al-Hidayah -<br><br>'+
    '📡 Live streaming<br><br>'+
    '📖 *'+ title +'*'+ episode + '<br>'+
    '&nbsp;&nbsp;&nbsp;_['+ book +']_ <br><br>'+
    '👤 Ustadz '+ name +' حفظه الله<br><br>'+
    '🗓️ '+ day_name +', '+ hj +'H / '+ date_selected_name +'<br><br>'+
    '⏰ '+ time +' - Selesai<br><br>'+
    '🎥 Link Kajian : <br>'+
    stream_link + ' <br><br>'+
    '➖➖➖➖➖➖➖➖➖<br><br>'+
    'Silahkan kunjungi : <br><br>'+
    '🌐 https://linktr.ee/masjidalhidayah';

    $('#code').val( copy_text.replace(/&nbsp;/g, ' ').replace(/<br\s*[\/]?>/gi, "\n") );
    
    function copyFunction() {
      var copyText = document.getElementById("code");
      copyText.select(); 
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      copyText.blur();
      
      $('#report_message').html('<div class="alert alert-success">Copied!!</div>').show().delay(2000).fadeOut();
    }

    $('#copy').click(function(){
      copyFunction();
    });
  });
</script>
</html>