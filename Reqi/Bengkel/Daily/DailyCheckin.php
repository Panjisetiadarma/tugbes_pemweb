<?php
session_start();

// Inisialisasi total poin
if (!isset($_SESSION['total_poin'])) {
  $_SESSION['total_poin'] = 0;
}

// Inisialisasi check-in status per hari
if (!isset($_SESSION['checked_in'])) {
  $_SESSION['checked_in'] = [];
}

// Cek jika ada klaim poin
if (isset($_GET['claim']) && isset($_GET['poin'])) {
  $day = intval($_GET['claim']);
  $poin = intval($_GET['poin']);

  // Cegah klaim ulang
  if (!in_array($day, $_SESSION['checked_in'])) {
    $_SESSION['total_poin'] += $poin;
    $_SESSION['checked_in'][] = $day;
    $_SESSION['message'] = "Berhasil klaim Hari ke-$day! +$poin poin.";
  } else {
    $_SESSION['message'] = "Hari ke-$day sudah diklaim sebelumnya.";
  }

  // Redirect untuk menghindari reload
  header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daily Check-In</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="checkin-style.css" />
</head>
<body>

<!-- NAVIGATION BAR -->
<div class="navbar">
  <div class="nav-left">
    <button class="btn-icon">
      <img src="gambar1.png" alt="Kiri" width="50" height="40">
    </button>
  </div>
  <div class="nav-right">
    <button class="btn-icon">
      <img src="gambar3.png" alt="Kanan" width="50" height="40">
    </button>
  </div>
</div>

<h2 class="my-5 text-center">Daily Check-In</h2>
<h4 class="text-center mb-3">Total Poin: <?= $_SESSION['total_poin'] ?> 🎉</h4>

<?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-info text-center"><?= $_SESSION['message']; ?></div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<div class="container text-center">
  <p>Check in setiap hari untuk mendapatkan poin! Raih hadiah menarik dengan login harian secara konsisten.</p>
  <div class="row">
    <?php
      $days = [
        ["Hari 1", 10, "Check-in pertama", "Bonus harian dimulai!", "btn-primary"],
        ["Hari 2", 20, "Check-in kedua", "Tambah semangatmu!", "btn-success"],
        ["Hari 3", 30, "Sudah tiga hari berturut-turut!", "Teruskan kebiasaan baik ini.", "btn-warning text-white"],
        ["Hari 4", 40, "Nyaris di tengah minggu!", "Jangan lewatkan kesempatan.", "btn-danger"],
        ["Hari 5", 50, "Lima hari berturut-turut!", "Bonus semakin besar!", "btn-purple text-white", "#6f42c1"],
        ["Hari 6", 100, "Kamu luar biasa!", "Besok hari ke-7!", "btn-purple text-white", "#3feae4"],
      ];

      foreach ($days as $index => $day) {
        $style = isset($day[5]) ? "style='background-color: {$day[5]};'" : "";
        $dayNumber = $index + 1;
        $isClaimed = in_array($dayNumber, $_SESSION['checked_in']);

        echo "
        <div class='col-md-4'>
          <div class='card mb-4'>
            <div class='card-header bg-light'>{$day[0]}</div>
            <div class='card-body'>
              <h5 class='card-title'>{$day[1]} Poin</h5>
              <p>{$day[2]}</p>
              <p>{$day[3]}</p>
            </div>
            <div class='card-footer'>";
        
        if ($isClaimed) {
          echo "<button class='btn btn-secondary' disabled>Sudah Check-In</button>";
        } else {
          echo "<a href='?claim=$dayNumber&poin={$day[1]}' class='btn {$day[4]}' {$style}>Check-In</a>";
        }

        echo "</div>
          </div>
        </div>";
      }
    ?>
  </div>
</div>

<footer class="mt-5 text-center"></footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
