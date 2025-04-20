<?php
session_start();
include('includes/config.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'] ?? null; 
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $location = $_POST['location'] ?? '';
    $size = $_POST['size'] ?? '';
    $bedrooms = $_POST['bedrooms'] ?? '';
    $bathrooms = $_POST['bathrooms'] ?? '';
    $year_built = $_POST['year_built'] ?? '';
    $features = $_POST['features'] ?? '';
    $imagePath = '';

    // Görsel yükleme işlemi
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $stmt = $pdo->prepare("INSERT INTO houses (user_id, title, description, price, location, size, bedrooms, bathrooms, year_built, features, image) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id, $title, $description, $price, $location, $size, $bedrooms, $bathrooms, $year_built, $features, $imagePath
    ]);

    $message = "Ev başarıyla eklendi!";
}
?>

<h2 style="text-align:center;">Yeni Ev Ekle</h2>

<div class="form-container">
    <?php if ($message): ?>
        <p style="color:green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Başlık:</label>
        <input type="text" name="title" required>

        <label>Açıklama:</label>
        <textarea name="description" required></textarea>

        <label>Fiyat (₺):</label>
        <input type="number" name="price" min="1" max="50000000" required>

        <label>Konum:</label>
        <input type="text" name="location">

        <label>Metrekare:</label>
        <input type="number" name="size" min="10" max="5000" required>

        <label>Yatak Odası Sayısı:</label>
        <input type="number" name="bedrooms" min="0" max="50" required>

        <label>Banyo Sayısı:</label>
        <input type="number" name="bathrooms" min="1" max="20" required>

        <label>Yapım Yılı:</label>
        <select name="year_built" required>
            <option value="">Yıl Seçin</option>
            <?php
            $current_year = date("Y");
            for ($year = $current_year; $year >= 1990; $year--) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>

        <label>Özellikler (ekstra):</label>
        <input type="text" name="features">

        <label>Görsel:</label>
        <input type="file" name="image">

        <button type="submit">Evi Kaydet</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
