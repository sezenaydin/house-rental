<?php
include('includes/config.php');
include('includes/header.php');

// Son 6 evi çek (4 göstereceğiz ama kaydırmak için fazlası iyi olur)
$stmt = $pdo->query("SELECT * FROM houses WHERE status = 'available' ORDER BY id DESC LIMIT 6");
$featuredHouses = $stmt->fetchAll();

?>

<div class="container mt-4 homepage">

    <!-- İçerik -->
    <main class="container">
    <section class="text-center fade-in">
        <h1 class="display-5 fw-bold">Hoş Geldiniz!</h1>
        <p class="lead">House Rental ile hayalinizdeki evi kolayca kiralayın veya kiraya verin.</p>
        <a href="house-listing.php" class="btn btn-outline-primary btn-lg mt-3">Evleri Görüntüle</a>
    </section>
    </main>
    <br>
    <!-- Swiper -->
    <div class="swiper mySwiper py-4">
        <div class="swiper-wrapper">
            <?php foreach ($featuredHouses as $house): ?>
                <div class="swiper-slide d-flex justify-content-center">
                    <div class="card shadow-sm d-flex flex-column justify-content-between" style="width: 100%; max-width: 300px; height: 330px;">
                        <?php if ($house['image']): ?>
                            <img src="<?php echo htmlspecialchars($house['image']); ?>" class="card-img-top" alt="Ev Görseli" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title" style="min-height: 48px; overflow: hidden;"><?php echo htmlspecialchars($house['title']); ?></h5>
                            <p class="card-text">Fiyat: ₺<?php echo number_format($house['price'], 2, ',', '.'); ?> / aylık</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Navigasyon Okları -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    
    <!-- Sayfa göstergesi -->
    <div class="swiper-pagination"></div>
</div>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-call mt-4 text-center">
            <p>Evleri favorilere eklemek veya kendi ilanınızı yayınlamak için <a href="login.php">Giriş yapın</a> veya <a href="register.php">Kayıt olun</a>.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Swiper Init Script -->
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        centeredSlides: false,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            }
        }
    });
</script>


<?php include('includes/footer.php'); ?>
