<?php


$host = 'localhost';  // Sunucu adı
$dbname = 'house_rental';  // Veritabanı adı
$username = 'root';  // Veritabanı kullanıcı adı
$password = '';  // Şifre (XAMPP'de genellikle boş)

try {
    // PDO bağlantısı oluşturuluyor
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Hata ayıklama modu aktif
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Oturum başlat
}



?>
