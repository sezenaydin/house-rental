
<?php
session_start();
include 'includes/config.php';  // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen veriler
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    try {
        // PDO ile veritabanına veri eklemek
        $sql = "INSERT INTO contact_messages (name, email, subject, message, status) 
                VALUES (:name, :email, :subject, :message, 'pending')";
        $stmt = $pdo->prepare($sql);

        // Verileri bağlama
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        // Veriyi veritabanına ekleme
        if ($stmt->execute()) {
            echo "Mesajınız başarıyla gönderildi!";
        } else {
            echo "Mesaj gönderilirken bir hata oluştu.";
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek!";
}
?>
