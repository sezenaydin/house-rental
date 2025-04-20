<?php
require_once('../includes/config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_houses.php");
    exit;
}

$house_id = $_GET['id'];

try {
    // Önce ilişkili cart verilerini sil
    $stmt1 = $pdo->prepare("DELETE FROM cart WHERE house_id = :id");
    $stmt1->bindParam(':id', $house_id, PDO::PARAM_INT);
    $stmt1->execute();

    // Sonra house tablosundan sil
    $stmt2 = $pdo->prepare("DELETE FROM houses WHERE id = :id");
    $stmt2->bindParam(':id', $house_id, PDO::PARAM_INT);
    $stmt2->execute();

    // Başarıyla silindi, yönlendir
    header("Location: manage_houses.php?status=deleted");
    exit;
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
