<?php
include('includes/config.php');
include('includes/header.php');
?>

<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4">Hizmetlerimiz</h2>
   <div class="row text-center">
        <!-- Kiralık Ev İlanları -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-home fa-4x mb-3 text-primary"></i>
                <h5 class="fw-bold">Kiralık Ev İlanları</h5>
                <p class="text-muted">Binlerce güncel ve doğrulanmış kiralık ev ilanı ile dilediğiniz evi bulun.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="house-listing.php" class="btn btn-primary rounded-pill px-4">İlanları Görüntüle</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Favori Listesi -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-heart fa-4x mb-3 text-danger"></i>
                <h5 class="fw-bold">Favori Listesi</h5>
                <p class="text-muted">Beğendiğiniz evleri favorilere ekleyin, daha sonra kolayca ulaşın ve karşılaştırın.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="favorites.php" class="btn btn-danger rounded-pill px-4">Favorilere Git</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Ev Ekleme -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-plus-circle fa-4x mb-3 text-warning"></i>
                <h5 class="fw-bold">Ev Ekleme</h5>
                <p class="text-muted">Kendi kiralık ev ilanınızı ekleyin ve geniş kullanıcı kitlesiyle paylaşın.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add-house.php" class="btn btn-warning rounded-pill px-4">Ev Ekle</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

   <div class="row text-center mt-4">
       <!-- Ödeme İşlemleri -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-credit-card fa-4x mb-3 text-secondary"></i>
                <h5 class="fw-bold">Ödeme İşlemleri</h5>
                <p class="text-muted">Ev kiralama işlemlerinizin ödeme adımlarını güvenli bir şekilde tamamlayın.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="payment.php" class="btn btn-secondary rounded-pill px-4">Ödeme Yap</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Ev Sahipleri Yönetim Paneli -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-cogs fa-4x mb-3 text-primary"></i>
                <h5 class="fw-bold">Ev Sahipleri Yönetim Paneli</h5>
                <p class="text-muted">Ev sahipleri ilanlarını kolayca yönetebilir ve güncelleyebilir.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="my_houses.php" class="btn btn-primary rounded-pill px-4">Paneli Görüntüle</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Ev İncelemeleri -->
        <div class="col-md-4 mb-4">
            <div class="service-card p-4 shadow-lg rounded border" style="height: 300px;">
                <i class="fa fa-comments fa-4x mb-3 text-dark"></i>
                <h5 class="fw-bold">Ev İncelemeleri</h5>
                <p class="text-muted">Evleri inceleyin ve başkalarının görüşlerini okuyarak kararınızı verin.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="checkout.php" class="btn btn-dark rounded-pill px-4">Yorumları Gör</a>
                <?php endif; ?>
            </div>
        </div>
   </div>


</div>

<?php include 'includes/footer.php'; ?>
