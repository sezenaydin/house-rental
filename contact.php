
<?php

session_start();
include 'includes/config.php';
include('includes/header.php');

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
            $success = "Mesajınız başarıyla gönderildi!";
        } else {
            $error = "Mesaj gönderilirken bir hata oluştu.";
        }
    } catch (PDOException $e) {
        $error = "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İletişim | House Rental</title>
    <style>
        .contact-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .contact-container h2 {
            margin-bottom: 20px;
        }
        .contact-container form input, .contact-container form textarea {
            width: 50%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .contact-container form button {
            padding: 12px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        .contact-info {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="contact-container">
    <h2>Bizimle İletişime Geçin</h2>

    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form id="contact-form" method="POST" action="" onsubmit="return validateForm()">
        <label for="name">Adınız:</label>
        <input type="text" id="name" name="name" placeholder="Adınızı girin" required>
        
        <label for="email">E-posta adresiniz:</label>
        <input type="email" id="email" name="email" placeholder="E-posta adresinizi girin" required>
        
        <label for="subject">Konu:</label>
        <input type="text" id="subject" name="subject" placeholder="Konu başlığını girin" required>
        
        <label for="message">Mesajınız:</label>
        <textarea id="message" name="message" rows="6" placeholder="Mesajınızı yazın" required></textarea>
        
        <button type="submit">Gönder</button>
    </form>

    <div id="feedback" style="display:none;">
        <p>Mesajınız başarıyla gönderildi!</p>
    </div>

    <div id="error-feedback" style="display:none; color:red;">
        <p>Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.</p>
    </div>

    <div class="contact-info">
        <h3>İletişim Bilgileri</h3>
        <p><strong>Adres:</strong> Eskişehir, Türkiye</p>
        <p><strong>E-posta:</strong> info@houserental.com</p>
        <p><strong>Telefon:</strong> +90 555 555 5555</p>
        <iframe 
            src="https://www.google.com/maps?q=Eskişehir,+Türkiye&output=embed"
            width="100%" height="250" style="border:0; margin-top:15px;" allowfullscreen loading="lazy">
        </iframe>
    </div>
</div>

<script>
    function validateForm() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var subject = document.getElementById('subject').value;
        var message = document.getElementById('message').value;
        
        // Basit doğrulama
        if (name == "" || email == "" || subject == "" || message == "") {
            alert("Lütfen tüm alanları doldurduğunuzdan emin olun.");
            return false;
        }

        // Formu ajax ile göndermek (sayfa yenilemeden)
        var formData = new FormData(document.getElementById('contact-form'));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_contact_form.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                document.getElementById('feedback').style.display = 'block';
                document.getElementById('contact-form').reset();  // Formu sıfırla
            } else {
                document.getElementById('error-feedback').style.display = 'block';
            }
        };
        xhr.send(formData);
        
        return false;  // Sayfanın yenilenmesini engelle
    }
</script>

</body>
</html>
