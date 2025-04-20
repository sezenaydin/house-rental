<?php
session_start();
include('../includes/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "UPDATE contact_messages SET status = 'read' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: dashboard.php");  // Admin paneline yönlendir
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?>
