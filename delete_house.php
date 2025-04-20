<?php
session_start();
include('includes/config.php');

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ev ID'sini al
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: my_houses.php");
    exit;
}

$house_id = $_GET['id'];

// Evin varlığını kontrol et
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ? AND user_id = ?");
$stmt->execute([$house_id, $user_id]);
$house = $stmt->fetch();

if (!$house) {
    header("Location: my_houses.php"); // Ev bulunamazsa yönlendir
    exit;
}

// Ev silme işlemi
$stmt = $pdo->prepare("DELETE FROM houses WHERE id = ?");
$stmt->execute([$house_id]);

$_SESSION['success_message'] = "Ev başarıyla silindi!";
header("Location: my_houses.php");
exit;
