<?php
session_start();

// Periksa apakah sesi username sudah diset
if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
} else {
    $loggedInUser = "Pengguna tidak terdaftar";
}
include '../navbar/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>
  <link rel="stylesheet" href="profile.css" />
  <script srl="profile.js"></script>
</head>
<body>

  <!-- Header Promo -->
  <div class="promo-bar"></div>

  <!-- Back Button -->
  <a href="../lobi/lobi.php">←</a>

  <!-- Profile Section -->
  <section class="profile-section">
    <div class="avatar-container">
      <div class="avatar">
        <img src="img/th.jpeg" alt="User Profile">
        <span class="edit-icon">✎</span>
      </div>
        <br>
          <div class="profile">
            <p style="font-size:20px;"><?php echo $loggedInUser; ?></p>
          </div>

    <a href="update_profile.php">
      <button class="profile-button">
        <span class="icon">📄</span> Profile
      </button>
    </div> </a>

    <!-- Menu Options -->
    <div class="menu-list">
    <a href="../tukangservis/rating.php" style="color:#000; text-decoration: none;" class="menu-item"><span class="icon">👥</span> Rating</a>
    <a href="../guide/guide.html" style="color:#000; text-decoration: none;" class="menu-item"><span class="icon">❓</span> Guide</a>
    <a href="qoin.php" style="color:#000; text-decoration: none;" class="menu-item"><span class="icon">⬢</span> Qoin</a>
    <a href="../lobi/logout.php" style="color:#000; text-decoration: none;" class="menu-item"><span class="icon">↩️</span> Sign Out</a>
  </div>

  <div class="floating-switch">
      <span class="icon sun">☀️</span>
      <label class="switch">
          <input type="checkbox" id="darkModeToggle">
          <span class="slider round"></span>
      </label>
      <span class="icon moon">🌙</span>
      </div>
    </section>
</body>
</html>
