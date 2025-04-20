<?php
session_start();
require_once('../includes/config.php');



// Oturum ve admin kontrolü
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// ID kontrolü
if (!isset($_GET['id'])) {
    header("Location: manage_houses.php");
    exit;
}

$house_id = $_GET['id'];

// Mevcut ev bilgilerini getir
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :id");
$stmt->execute([':id' => $house_id]);
$house = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$house) {
    echo "Ev bulunamadı!";
    exit;
}

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $year_built = $_POST['year_built'];
    $features = $_POST['features'];

    // Güncelleme sorgusu
    $update = $pdo->prepare("UPDATE houses SET title = :title, description = :description, price = :price, location = :location, size = :size, bedrooms = :bedrooms, bathrooms = :bathrooms, year_built = :year_built, features = :features WHERE id = :id");

    $update->execute([
        ':title' => $title,
        ':description' => $description,
        ':price' => $price,
        ':location' => $location,
        ':size' => $size,
        ':bedrooms' => $bedrooms,
        ':bathrooms' => $bathrooms,
        ':year_built' => $year_built,
        ':features' => $features,
        ':id' => $house_id
    ]);

    header("Location: manage_houses.php?status=updated");
    exit;
}
?>

<!-- Bootstrap stil bağlantısı (varsa tekrar ekleme) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Ev Bilgilerini Güncelle</h2>
        <div>
            <a href="./dashboard.php" class="btn btn-outline-dark me-2">Dashboard'a Dön</a>
            <a href="manage_houses.php" class="btn btn-secondary">Ev Listesine Geri Dön</a>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form method="POST">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Başlık</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($house['title']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Konum</label>
                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($house['location']) ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($house['description']) ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fiyat (₺)</label>
                        <input type="number" name="price" class="form-control" value="<?= $house['price'] ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Metrekare</label>
                        <input type="number" name="size" class="form-control" value="<?= $house['size'] ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Yapım Yılı</label>
                        <input type="number" name="year_built" class="form-control" value="<?= $house['year_built'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Oda Sayısı</label>
                        <input type="number" name="bedrooms" class="form-control" value="<?= $house['bedrooms'] ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Banyo Sayısı</label>
                        <input type="number" name="bathrooms" class="form-control" value="<?= $house['bathrooms'] ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Özellikler</label>
                        <textarea name="features" class="form-control" rows="2"><?= htmlspecialchars($house['features']) ?></textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-5 me-2">Güncelle</button>
                    <a href="manage_houses.php" class="btn btn-outline-secondary px-4">İptal</a>
                </div>
            </form>
        </div>
    </div>
</div>
