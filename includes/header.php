<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$user = null;
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  
  require_once 'config.php'; 
  $stmt = $pdo->prepare("SELECT profile_photo FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>House Rental</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <span>House</span><span>Rental</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars text-dark"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item"><a class="nav-link" href="index.php">Ana Sayfa</a></li>
        <li class="nav-item"><a class="nav-link" href="house-listing.php">Evlerimiz</a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Hakkımızda
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../about.php">Hakkımızda</a></li>
            <li><a class="dropdown-item" href="services.php">Hizmetler</a></li>
            <li><a class="dropdown-item" href="sss.php">S.S.S.</a></li>
        </ul>
    </li>
        <li class="nav-item"><a class="nav-link" href="contact.php">İletişim</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          
          <?php if ($_SESSION['user_role'] == 'user'): ?>
            <!-- Kullanıcıya özel -->
             
            <li class="nav-item"><a class="nav-link" href="favorites.php">Favorilerim</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                Profilim
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="my_houses.php">Evlerim</a></li>
                <li><a class="dropdown-item" href="add-house.php">Ev Ekle</a></li>
                <li><a class="dropdown-item" href="account_settings.php">Hesap Ayarları</a></li>
              </ul>
            </li>

          <?php elseif ($_SESSION['user_role'] == 'admin'): ?>
            <!-- Admin'e özel -->
            <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin Paneli</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
            
        <?php else: ?>
          <!-- Giriş yapmamış ziyaretçiye -->
          <li class="nav-item"><a class="nav-link" href="login.php">Giriş Yap</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>
        <?php endif; ?>

      </ul>

      <ul class="navbar-nav d-flex flex-row">
        
        <li class="nav-item me-3"><a class="nav-link" href="#"><i class="fas fa-home nav-icon"></i></a></li>
        <li class="nav-item me-3"><a class="nav-link" href="#"><i class="fab fa-facebook nav-icon"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fab fa-instagram nav-icon"></i></a></li>
      </ul>

      
    </div>
  </div>
</nav>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('navbar-scrolled');
    } else {
      navbar.classList.remove('navbar-scrolled');
    }
  });

  document.addEventListener("DOMContentLoaded", () => {
    const fadeEls = document.querySelectorAll('.fade-in');
    fadeEls.forEach((el, index) => {
      setTimeout(() => {
        el.classList.add('visible');
      }, index * 300);
    });
  });
</script>

</body>
</html>
