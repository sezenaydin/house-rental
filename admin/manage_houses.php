<?php
session_start();
include('../includes/config.php');

// Admin kontrolü
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "house_rental");
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

// Evleri çek
$sql = "SELECT * FROM houses ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ev Yönetimi | House Rental</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
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

        .table-responsive {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        .alert-warning {
            background-color: #f39c12;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions .btn {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .btn-info {
            background-color: #3498db;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Ev Yönetimi</h2>

    <a href="./dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Panel'e Dönüş</a>

    <a href="./add_house.php" class="button"><i class="fas fa-plus-circle"></i> Ev Ekle</a>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Fiyat</th>
                        <th>Konum</th>
                        <th>Oda / Banyo</th>
                        <th>m²</th>
                        <th>Yapım Yılı</th>
                        <th>Özellikler</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= number_format($row['price'], 2); ?> ₺</td>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td><?= $row['bedrooms']; ?> / <?= $row['bathrooms']; ?></td>
                            <td><?= $row['size']; ?> m²</td>
                            <td><?= $row['year_built']; ?></td>
                            <td><?= htmlspecialchars($row['features']); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="edit_house.php?id=<?= $row['id']; ?>" class="btn btn-info">Düzenle</a>
                                    <a href="delete_house.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bu evi silmek istediğinize emin misiniz?');">Sil</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert-warning">
            Henüz eklenmiş ev bulunmuyor.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
