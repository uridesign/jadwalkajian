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
      </div>

      <div class="row justify-content-center py-5">
        <div class="col col-md-10">
          <h1><span id="title"><?php echo $row_kajian['kajian_title'];?></span></h1>
          <?php if( $row_kajian['episode'] > 1) echo '<p>Episode : '. $row_kajian['episode'] .'</p>' ?>
          <h2 class="h5" style="font-weight: 500"><span id="book"><?php echo 'Kajian ' . $row_kajian['kitab_name']?></span></h2>
          <h3 class="h2" style="font-weight: 600">Ustadz <span id="name"><?php echo $row_kajian['ustadz_name']?></span> حفظه الله</h3>
          <p><span id="date"><?php echo $row_kajian['date']?></span></p>

          <div class="row">
            <div class="col-12 mb-3 col-md-6 mb-md-0">
              <div class="mb-3">
                <label for="">Preview Whatsapp</label>
                <textarea name="code" id="code" class="preview" disabled></textarea>
              </div>
              <div>
                <a href="javascript:;" id="copy" class="btn button-1">Copy to WhatsApp</a>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <form id="preview_send_tg" action="post_kajian.php" method="POST">
                <div class="mb-3">
                  <label for="">Preview Telegram</label>
                  <textarea name="code_tg" id="code_tg" class="preview" disabled></textarea>
                </div>
                <div>
                  <button type="submit" class="btn button-1">Send to Telegram</button>
                </div>
              </form>
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
    var book_tg;
    var name = $('#name').text();
    var date = $('#date').text();
    var time = $('#time').text();

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

    var copy_text = '*📢 INFO KAJIAN MASJID AL-HIDAYAH*<br><br>'+
    'بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم<br><br>'+
    'Hadirilah Majelis Ilmu<br>'+
    'Kajian Islam Ilmiah Untuk Umum<br><br>'+
    'In Syaa Allah<br><br>'+
    '_📖 Tema_<br>'+
    '*'+ title +''+ episode +'*<br>'+
    '_['+ book +']_<br><br>'+
    '_👤 Pemateri_<br>'+
    '*Ustadz '+ name +' حفظه الله*<br><br>'+
    '_🗓️ Hari/Tanggal_<br>'+
    '*'+ hj +'H*<br>'+
    day_name +', '+ date_selected_name +'<br><br>'+
    '_🕓 Waktu_<br>'+
    '*'+ time +' - Selesai*<br><br>'+
    '_🕌 Tempat_<br>*Masjid Al-Hidayah*<br>'+ 
    'Jl. Batu Bulan No.27<br>Kapuk Cengkareng Jakarta Barat<br>(Dekat SMP.100)<br>'+
    'Link lokasi: https://maps.app.goo.gl/bAwDrrUFeu5FJzuS9<br><br>'+
    '_☎ Informasi Lanjut_<br>'+ 
    '*Ikhwan*:<br>'+ 
    '081295562662<br>08129898393<br><br>'+
    '*Akhwat*:<br>'+
    '081219544878<br>082110150517<br><br>'+
    '_Social Media_<br>'+ 
    'Youtube: https://youtube.com/@masjidalhidayahkapuk<br>'+
    'Instagram: https://instagram.com/masjidalhidayahkapuk<br>'+
    'Facebook: https://facebook.com/masjidalhidayahkapuk<br>'+
    'Telegram: https://t.me/masjidalhidayahkapuk<br><br>'+
    '==============================<br><br>'+
    '*Donasi Dakwah Masjid Al-Hidayah:*<br>'+
    'Bank Syariah Indonesia<br>'+
    'No rek. 7997998558<br>'+
    'a.n. Masjid Al Hidayah RW 008<br><br>'+
    '==============================<br><br>'+
    '_✒ Mutiara sunnah_<br><br>'+
    "RASULULLAH SHALLALLAAHU 'ALAIHI WA SALLAM bersabda :<br><br>"+
    'مَنْ سَلَكَ طَرِيْقًا يَلْتَمِسُ فِيْهِ عِلْمًا، سَهَّلَ اللهُ لَهُ بِهِ طَرِيْقًا إِلَى الْجَنَّةِ<br><br>'+
    '“Barang siapa yang menempuh suatu jalan untuk menuntut ilmu, Allah akan mudahkan baginya jalan ke surga” (HR. Muslim).<br><br>'+
    '==============================<br><br>'+
    '_DIMOHON TIDAK MELIPUT KAJIAN & TIDAK MENGEDIT VIDEO KAJIAN TANPA SEIZIN PIHAK PANITIA_<br><br>'+
    'Dipersilahkan berbagi informasi ini, Semoga bermanfaat<br>'+
    'Jazaakumullahu Khairan';

    var copy_text_tg = '<b>📢 INFO KAJIAN MASJID AL-HIDAYAH</b><br><br>'+
    'بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم<br><br>'+
    'Hadirilah Majelis Ilmu<br>'+
    'Kajian Islam Ilmiah Untuk Umum<br><br>'+
    'In Syaa Allah<br><br>'+
    '<i>📖 Tema</i><br>'+
    '<b>'+ title +''+ episode +'</b><br>'+
    '<i>['+ book +']</i><br><br>'+
    '<i>👤 Pemateri</i><br>'+
    '<b>Ustadz '+ name +' حفظه الله</b><br><br>'+
    '<i>🗓️ Hari/Tanggal</i><br>'+
    '<b>'+ hj +'H</b><br>'+
    day_name +', '+ date_selected_name +'<br><br>'+
    '<i>🕓 Waktu</i><br>'+
    '<b>'+ time +' - Selesai</b><br><br>'+
    '<i>🕌 Tempat</i><br><b>Masjid Al-Hidayah</b><br>'+ 
    'Jl. Batu Bulan No.27<br>Kapuk Cengkareng Jakarta Barat<br>(Dekat SMP.100)<br>'+
    'Link lokasi: https://maps.app.goo.gl/bAwDrrUFeu5FJzuS9<br><br>'+
    '<i>☎ Informasi Lanjut</i><br>'+ 
    '<b>Ikhwan</b>:<br>'+ 
    '081295562662<br>08129898393<br><br>'+
    '<b>Akhwat</b>:<br>'+
    '081219544878<br>082110150517<br><br>'+
    '<i>Social Media</i><br>'+ 
    'Youtube: https://youtube.com/@masjidalhidayahkapuk<br>'+
    'Instagram: https://instagram.com/masjidalhidayahkapuk<br>'+
    'Facebook: https://facebook.com/masjidalhidayahkapuk<br>'+
    'Telegram: https://t.me/masjidalhidayahkapuk<br><br>'+
    '==============================<br><br>'+
    '<b>Donasi Dakwah Masjid Al-Hidayah:</b><br>'+
    'Bank Syariah Indonesia<br>'+
    'No rek. 7997998558<br>'+
    'a.n. Masjid Al Hidayah RW 008<br><br>'+
    '==============================<br><br>'+
    '<i>✒ Mutiara sunnah</i><br><br>'+
    "RASULULLAH SHALLALLAAHU 'ALAIHI WA SALLAM bersabda :<br><br>"+
    'مَنْ سَلَكَ طَرِيْقًا يَلْتَمِسُ فِيْهِ عِلْمًا، سَهَّلَ اللهُ لَهُ بِهِ طَرِيْقًا إِلَى الْجَنَّةِ<br><br>'+
    '“Barang siapa yang menempuh suatu jalan untuk menuntut ilmu, Allah akan mudahkan baginya jalan ke surga” (HR. Muslim).<br><br>'+
    '==============================<br><br>'+
    '<i>DIMOHON TIDAK MELIPUT KAJIAN & TIDAK MENGEDIT VIDEO KAJIAN TANPA SEIZIN PIHAK PANITIA</i><br><br>'+
    'Dipersilahkan berbagi informasi ini, Semoga bermanfaat<br>'+
    'Jazaakumullahu Khairan';

    $('#code').val( copy_text.replace(/&nbsp;/g, ' ').replace(/<br\s*[\/]?>/gi, "\n") );
    $('#code_tg').val( copy_text_tg.replace(/&nbsp;/g, ' ').replace(/<br\s*[\/]?>/gi, "\n") );
    
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