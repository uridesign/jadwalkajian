<?php
  // Initialize the session
  session_start();  
  
  $timeout = 15;
  $logout = "login.php";

  $timeout = $timeout * 60; // menit ke detik
  
  if(isset($_SESSION['start_session'])){
    $elapsed_time = time()-$_SESSION['start_session'];
    if($elapsed_time >= $timeout){
      session_destroy();
      // header("location: login.php");
    }
  }

  $_SESSION['start_session']=time();

  // Check if the user is logged in, if not then redirect him to login page
  // if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  //   $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
  //   header("location: login.php");
  //   exit;
  // }
?>