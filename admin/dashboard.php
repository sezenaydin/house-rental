<?php
session_start();
include('../includes/config.php');


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <title>House Rental</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <!-- Swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
            
           <body>
                <!-- Dashboard Layout -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar -->
                        <nav class="col-md-2 d-none d-md-block  sidebar vh-100">
                            <div class="position-sticky pt-3">
                                <h5 class="text-black px-5 ">Yönetim</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link px-8 text-black " href="dashboard.php"> Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="../index.php">Kullanıcı Sayfası</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="manage_users.php"> Kullanıcı Yönetimi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="manage_houses.php">Emlak Yönetimi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="admin_reports.php">Raporlar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="contact_message.php">İletişim Formları</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="#">Bildirimler</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="#">Arama</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="#">Ayarlar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-black" href="../logout.php">Çıkış</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Main Content -->
                        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                                <h2 class="h4">Admin Paneli</h2>
                                <div class="text-muted">Hoş geldiniz, <strong><?php echo $_SESSION['user_name']; ?></strong></div>
                            </div>

                            <div class="row g-4">
                                <!-- Kullanıcı Yönetimi -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Kullanıcılar</h5>
                                            <p>Kullanıcıları görüntüleyin, düzenleyin ve silin.</p>
                                            <a href="manage_users.php" class="btn btn-primary">Yönet</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emlak Yönetimi -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Emlaklar</h5>
                                            <p>Evleri ekleyin, düzenleyin veya kaldırın.</p>
                                            <a href="manage_houses.php" class="btn btn-success">Yönet</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Raporlar -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Raporlar</h5>
                                            <p>Performansı analiz edin, grafiklerle görüntüleyin.</p>
                                            <a href="admin_reports.php" class="btn btn-warning">Görüntüle</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bildirimler -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Bildirimler</h5>
                                            <p>Kayıtlar ve talepler için uyarılar.</p>
                                            <a href="#" class="btn btn-danger">Kontrol Et</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arama -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Arama</h5>
                                            <p>Kullanıcılar veya evleri hızlıca bulun.</p>
                                            <a href="#" class="btn btn-secondary">Ara</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ayarlar -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center">
                                            <h5>Ayarlar</h5>
                                            <p>Sistem yapılandırmaları ve tercihler.</p>
                                            <a href="#" class="btn btn-dark">Yapılandır</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
         </body>
</html>