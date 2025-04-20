<?php
session_start();
include('../includes/config.php');


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
        $uploadDir = '../uploads';
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

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Ev Ekle | House Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f8fc;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            margin-top: 50px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        label {
            color: #555;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .message {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .file-input {
            background-color: #f9f9f9;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
<a href="./dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Panel'e Dönüş</a>
    <h2>Yeni Ev Ekle</h2>
    
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="title">Başlık</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Açıklama</label>
        <textarea name="description" id="description" required placeholder="Ev hakkında detaylı bilgi yazın..."></textarea>

        <label for="price">Fiyat (₺)</label>
        <input type="number" name="price" id="price" min="1" max="50000000" required>

        <label for="location">Konum</label>
        <input type="text" name="location" id="location" required>

        <label for="size">Metrekare</label>
        <input type="number" name="size" id="size" min="10" max="5000" required>

        <label for="bedrooms">Yatak Odası Sayısı</label>
        <input type="number" name="bedrooms" id="bedrooms" min="0" max="50" required>

        <label for="bathrooms">Banyo Sayısı</label>
        <input type="number" name="bathrooms" id="bathrooms" min="1" max="20" required>

        <label for="year_built">Yapım Yılı</label>
        <select name="year_built" id="year_built" required>
            <option value="">Yıl Seçin</option>
            <?php
            $current_year = date("Y");
            for ($year = $current_year; $year >= 1990; $year--) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>

        <label for="features">Özellikler (ekstra)</label>
        <input type="text" name="features" id="features">

        <label for="image">Görsel</label>
        <input type="file" name="image" id="image" class="file-input">

        <button type="submit">Evi Kaydet</button>
    </form>
</div>


</body>
</html>
