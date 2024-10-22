<?php
  // Session check login required  
  // include('includes/session_check.php');
  $page_name = 'broadcast';

  $botApiToken = '5163636753:AAFfQCA9MAGxLUvZa8ZBhOHTPQNPQ_MyKp4';
  $channelId ='@masjidalhidayahkapuk';
  $message = $_POST['code_tg'];

  $query = http_build_query([
    'chat_id' => $channelId,
    "parse_mode" => "html",
    'disable_notification' => false,
    'text' => $message
  ]);
  $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";

  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
  ));
  curl_exec($curl);
  curl_close($curl);
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Masjid Al-Hidayah | Share Jadwal via Telegram</title>

  <?php include 'includes/head.php';?>
</head>
<body>
  <header>
    <?php include('includes/header.php'); ?>
  </header>
  <main>
    <div class="py-5">
      <div class="wrapper">
        <h1 class="h2 mb-5">Post Kajian</h1>
        <div class="mt-4">
          <p class="h6 fw-normal mb-4">Pesan sudah berhasil disebarkan</p>
          <a class="btn btn-primary" href="./">Kembali</a>
        </div>
      </div>
    </div>
  </main>
</body>
</html>