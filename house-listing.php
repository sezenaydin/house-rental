<?php
include('includes/config.php');
include('includes/header.php');

$where = [];
$params = [];

// Filtreleme işlemleri
if (!empty($_GET['min_price'])) {
    $where[] = "price >= :min_price";
    $params['min_price'] = (int)$_GET['min_price'];
}

if (!empty($_GET['max_price'])) {
    $where[] = "price <= :max_price";
    $params['max_price'] = (int)$_GET['max_price'];
}

if (!empty($_GET['location'])) {
    $where[] = "location LIKE :location";
    $params['location'] = '%' . $_GET['location'] . '%';
}

if (!empty($_GET['bedrooms'])) {
    $where[] = "bedrooms >= :bedrooms";
    $params['bedrooms'] = (int)$_GET['bedrooms'];
}
// Filtreleme açıklaması oluştur
$filter_messages = [];

if (!empty($_GET['min_price'])) {
    $filter_messages[] = "₺" . number_format($_GET['min_price'], 0, ',', '.') . " ve üzeri fiyat";
}
if (!empty($_GET['max_price'])) {
    $filter_messages[] = "₺" . number_format($_GET['max_price'], 0, ',', '.') . " ve altı fiyat";
}
if (!empty($_GET['location'])) {
    $filter_messages[] = "'" . htmlspecialchars($_GET['location']) . "' konumunda";
}
if (!empty($_GET['bedrooms'])) {
    $filter_messages[] = $_GET['bedrooms'] . "+ yatak odalı";
}
if (!empty($_GET['bathrooms'])) {
    $filter_messages[] = $_GET['bathrooms'] . "+ banyolu";
}

$filter_text = '';
if (!empty($filter_messages)) {
    $filter_text = "🔎 <strong>Filtreleme sonuçları:</strong> " . implode(", ", $filter_messages) . " ve <strong>müsait</strong> evler listeleniyor.";
}

$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$statusCondition = "status = 'available'";
$whereSql = count($where) ? 'WHERE ' . $statusCondition . ' AND ' . implode(' AND ', $where) : 'WHERE ' . $statusCondition;
$query = "SELECT * FROM houses $whereSql";


$stmt = $pdo->prepare($query);
$stmt->execute($params);
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Maksimum açıklama uzunluğu
$max_description_length = 100;
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Mevcut Kiralık Evler</h2>
    <div class="row">
       <!-- Filtre Kısmı -->
        <div class="col-md-3">
            <div class="card p-3">
                <h4>Filtrele</h4>
                <form method="GET">
                    <!-- Min Fiyat -->
                    <div class="mb-3">
                        <label for="min_price" class="form-label">Min ₺</label>
                        <input type="number" name="min_price" class="form-control" placeholder="1" min="1" max="50000000">
                    </div>
                    
                    <!-- Max Fiyat -->
                    <div class="mb-3">
                        <label for="max_price" class="form-label">Max ₺</label>
                        <input type="number" name="max_price" class="form-control" placeholder="10000" min="1" max="50000000">
                    </div>

                    <!-- Konum Filtreleme: İl ve İlçe -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Konum (İl/İlçe)</label>
                        <input type="text" name="location" class="form-control" placeholder="İlçe veya İl Girin">
                    </div>

                    <!-- Yatak Odası Sayısı -->
                    <div class="mb-3">
                        <label for="bedrooms" class="form-label">Oda Sayısı</label>
                        <select name="bedrooms" class="form-select">
                            <option value="">Seçiniz</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                            <option value="6">6+</option>
                            <option value="7">7+</option>
                            <option value="8">8+</option>
                            <option value="9">9+</option>
                            <option value="10">10+</option>
                        </select>
                    </div>

                    <!-- Banyo Sayısı (opsiyonel) -->
                    <div class="mb-3">
                        <label for="bathrooms" class="form-label">Banyo Sayısı</label>
                        <select name="bathrooms" class="form-select">
                            <option value="">Seçiniz</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                            <option value="6">6+</option>
                            <option value="7">7+</option>
                            <option value="8">8+</option>
                            <option value="9">9+</option>
                            <option value="10">10+</option>
                        </select>
                    </div>

                    <!-- Ekleme Butonu -->
                    <button type="submit" class="btn btn-primary w-100">Filtrele</button>
                </form>
            </div>
        </div>


        <!-- Evler Listesi -->
        <div class="col-md-9">
        <?php if ($filter_text): ?>
            <div class="alert alert-info mb-3">
                <?= $filter_text ?>
            </div>
        <?php endif; ?>

            <div class="row">

                <?php foreach ($houses as $house): ?>
                    <?php
                    // Açıklamayı kısaltmak için
                    $short_description = strlen($house['description']) > $max_description_length
                        ? substr($house['description'], 0, $max_description_length) . '...'
                        : $house['description'];
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <?php if ($house['image']): ?>
                                <img src="<?php echo htmlspecialchars($house['image']); ?>" class="card-img-top" alt="Ev Görseli" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($house['title']); ?></h5>
                                <!-- Kısaltılmış açıklama -->
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($short_description)); ?></p>
                                <p><strong>Fiyat:</strong> ₺<?php echo number_format($house['price'], 2, ',', '.'); ?></p>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form method="GET" action="add-favorite.php" class="mb-1">
                                        <input type="hidden" name="house_id" value="<?php echo $house['id']; ?>">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Favorilere Ekle</button>
                                    </form>

                                    <form method="GET" action="checkout.php" class="mb-1">
                                        <input type="hidden" name="house_id" value="<?php echo $house['id']; ?>">
                                        <button type="submit" class="btn btn-outline-success btn-sm">Detayları Gör</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (count($houses) == 0): ?>
                    <div class="col-12">
                        <div class="alert alert-warning">Aramanıza uygun ev bulunamadı.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
