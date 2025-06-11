<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dasboard</title>
    <link rel="stylesheet" href="lobi.css"> 
</head>

<body>
    <?php include '../navbar/navbar.php';?>
    <link rel="stylesheet" href="../navbar/nav.css">
    <script src="../navbar/nav.js"></script>
    
    <!-- SVG Background -->
   <div class="svg-background">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#0099ff" fill-opacity="1"
                d="M0,256L48,261.3C96,267,192,277,288,256C384,235,480,181,576,181.3C672,181,768,235,864,224C960,213,1056,139,1152,106.7C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="banner">
        <div class="help-card">
            <p>Let's start loving our vehicles, We are here for helping</p>
        </div>
    </section>

    <section class="promo">
         <div class="card-promo">
            <h3>Voucher</h3>
            <p>Check Your Discount!</p>
                <a href="../promo/fiturpromo.php">More Detail →</a>
        </div>
    </section>

    <section class="features">
        <div class="card" data-link="catalog.html">
            <h3>Catalog</h3>
            <p>Service Package Sparepart</p>
            <button><a href="../rizal/index.php"> More Detail →</a></button>
        </div>

        <div class="card" data-link="daily-check.html">
            <h3>Daily Check In</h3>
            <p>Day 5/7</p>
            <button><a href="../Reqi/Bengkel/Daily/Dailycheckin.php"> More Detail →</a></button>
        </div>
        
        <div class="card" data-link="service.html">
            <h3>Service</h3>
            <p>Service Package Sparepart</p>
            <button><a href="../jadwalservis/jadwal.php"> More Detail →</a></button>
        </div>
        
    </section>

   <!-- Tombol switch dark mode  -->
    <div class="floating-switch">
    <span class="icon sun">☀️</span>
    <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider round"></span>
    </label>
    <span class="icon moon">🌙</span>
    </div>

   <script src="lobi.js"></script> 
</body>
</html>
 