<?php
session_start();
include('../includes/config.php');


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "house_rental");

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger text-center mt-5'>Kullanıcı ID'si alınamadı.</div>";
    exit;
}

$conn->query("DELETE FROM users WHERE id = $id");

echo "<div class='container mt-5'>
        <div class='alert alert-success text-center'>
            Kullanıcı başarıyla silindi!
            <br><br>
            <a href='manage_users.php' class='btn btn-outline-primary mt-3'>Geri Dön</a>
        </div>
      </div>";


?>
