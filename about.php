<?php
include('includes/config.php');
include('includes/header.php');

?>
<html>
    <head>
        
    </head>
    <!-- Hakkımızda Bölümü -->
    <div class="container-fluid p-0">
    <div class="position-relative">
        <!-- Arka Plan Fotoğrafı -->
        <img src="assets/images/about.jpg" class="img-fluid w-100 " alt="Hakkımızda" style="opacity: 0.7; height: 100vh; object-fit: cover;">

        <!-- Üst Yazılar -->
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h2 class="fw-bold display-4">Hakkımızda</h2>
        <p class="lead">Ev Kiralama Kolaylaştı!</p>
        </div>
    </div>
    </div>

    <div class="container mt-5 mb-5">
    <div class="row align-items-center">
        <!-- Sol taraf: Misyonumuz Metni -->
        <div class="col-md-6 mb-4">
        <h4 class="mb-3">Misyonumuz</h4>
        <p class="text-justify">Amacımız, kiralık ev arayan kullanıcılarla ev sahiplerini güvenli, hızlı ve şeffaf bir şekilde buluşturmak. Geliştirdiğimiz kullanıcı dostu arayüz ve gelişmiş filtreleme sistemleriyle, hayalinizdeki evi birkaç tıklamayla bulabilirsiniz.</p>

        <h4 class="mt-4 mb-3">Neden Bizi Tercih Etmelisiniz?</h4>
        <ul class="list-unstyled">
            <li>✔️ Kolay ve hızlı kiralama süreci</li>
            <li>✔️ Güvenilir ev sahipleri ve doğrulanmış ilanlar</li>
            <li>✔️ 7/24 müşteri desteği</li>
            <li>✔️ Favorilere ekleme ve karşılaştırma özellikleri</li>
        </ul>
        </div>

        <!-- Sağ taraf: Fotoğraf -->
        <div class="col-md-6 mb-4">
        <img src="assets/images/about2.jpg" class="img-fluid rounded shadow-lg" alt="Hakkımızda">
        </div>
    </div>

    <div class="mt-5 text-center">
        <h5 class="fw-semibold text-dark">Gelin, sizi hayalinizdeki eve kavuşturalım!</h5>
        <a href="house-listing.php" class="btn btn-primary mt-3 px-4 rounded-pill">Evleri Görüntüle</a>
    </div>
    </div>
</html>
<?php include 'includes/footer.php'; ?>
