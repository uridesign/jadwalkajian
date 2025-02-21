<div class="wrapper">
  <a href="./" id="logo">Jadwal Kajian</a>
  <nav>
    <ul>
      <li><a href="./input-jadwal.php">Input Jadwal</a></li>
      <li><a href="./ustadz.php">Manage Ustadz</a></li>
      <li><a href="./settings.php">Settings Hijr</a></li>
      <?php
        if ( isset($_SESSION["loggedin"]) ) {
          echo '<li><a href="./logout.php">Logout</a></li>';
        }
      ?>
    </ul>
  </nav>
</div>