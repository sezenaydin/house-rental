<?php
include('includes/config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$house_id = $_GET['house_id'] ?? null;

if ($house_id) {
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO favorites (user_id, house_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $house_id]);
    } catch (PDOException $e) {
        // Hata loglanabilir
    }
}

header("Location: house-listing.php");
exit;
