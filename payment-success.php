<?php
session_start();
include 'includes/config.php';
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['house_id'])) {
    header("Location: index.php");
    exit();
}

$houseId = $_GET['house_id'];
$userId = $_SESSION['user_id'];

// Ev bilgisi
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :house_id");
$stmt->bindParam(':house_id', $houseId, PDO::PARAM_INT);
$stmt->execute();
$house = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$house) die("Ev bulunamadı.");

// Kiralama bilgisi
$stmtRental = $pdo->prepare("SELECT * FROM rentals WHERE house_id = :house_id AND user_id = :user_id ORDER BY id DESC LIMIT 1");
$stmtRental->bindParam(':house_id', $houseId);
$stmtRental->bindParam(':user_id', $userId);
$stmtRental->execute();
$rental = $stmtRental->fetch(PDO::FETCH_ASSOC);

$startDate = $rental ? $rental['start_date'] : 'Belirtilmedi';
$endDate = $rental ? $rental['end_date'] : 'Belirtilmedi';

$daysRented = ($startDate !== 'Belirtilmedi' && $endDate !== 'Belirtilmedi')
    ? (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24)
    : 0;

$totalAmount = $house['price'] * $daysRented;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ödeme Başarılı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .success-icon {
            font-size: 64px;
            color: #28a745;
        }
        .btn-home {
            background: #007bff;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
        }
        .btn-home:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card p-4 col-lg-8 col-md-10 col-sm-12">
        <div class="text-center">
            <div class="success-icon mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="text-success">Ödeme Başarılı!</h2>
            <p class="text-muted">Kiralama işleminiz başarıyla tamamlandı.</p>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 mb-3">
                <p><strong>Ev Adı:</strong> <?= htmlspecialchars($house['title']) ?></p>
                <p><strong>Ev Fiyatı (Günlük):</strong> ₺<?= number_format($house['price'], 2, ',', '.') ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <p><strong>Başlangıç Tarihi:</strong> <?= $startDate ?></p>
                <p><strong>Bitiş Tarihi:</strong> <?= $endDate ?></p>
            </div>
        </div>
        <div class="text-center">
            <p><strong>Toplam Kiralama Süresi:</strong> <?= $daysRented ?> gün</p>
            <p><strong>Toplam Tutar:</strong> ₺<?= number_format($totalAmount, 2, ',', '.') ?></p>
            <a href="index.php" class="btn-home mt-3">Anasayfaya Dön</a>
        </div>
    </div>
</div>

<!-- FontAwesome CDN -->
<script src="https://kit.fontawesome.com/a2e0e6a97d.js" crossorigin="anonymous"></script>
</body>
</html>
