<?php
session_start();
include 'includes/config.php';  // PDO bağlantısı config.php'den dahil ediliyor

if (!isset($_SESSION['user_id']) || !isset($_GET['house_id'])) {
    header("Location: favorites.php");
    exit();
}

$userId = $_SESSION['user_id'];
$houseId = $_GET['house_id'];

// PDO üzerinden veritabanı işlemi yapıyoruz
try {
    // PDO ile DELETE sorgusu hazırlıyoruz
    $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = :user_id AND house_id = :house_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':house_id', $houseId, PDO::PARAM_INT);
    $stmt->execute();  // Sorguyu çalıştır

    // Favoriler sayfasına yönlendirme
    header("Location: favorites.php");
    exit();
} catch (PDOException $e) {
    die("Hata: " . $e->getMessage());
}
?>
