<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['house_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$houseId = $_GET['house_id'];

try {
    // Sepete ekleme işlemi
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, house_id) VALUES (:user_id, :house_id)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':house_id', $houseId, PDO::PARAM_INT);
    $stmt->execute();

    
    header("Location: checkout.php?house_id=$houseId");
    
    exit();
} catch (PDOException $e) {
    die("Hata: " . $e->getMessage());
}
?>
