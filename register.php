<?php
include('includes/config.php');
include('includes/header.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Email kontrolü
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $message = "Bu email adresi zaten kayıtlı.";
    } elseif ($password !== $confirm_password) {
        $message = "Şifreler uyuşmuyor.";
    } else {
        // Şifreyi hashle
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Profil fotoğrafı yükleme
        $profile_photo_path = null;
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
            $upload_dir = 'uploads/';
            $file_name = time() . '_' . basename($_FILES['profile_photo']['name']);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
                $profile_photo_path = $target_path;
            }
        }

        // Kullanıcıyı veritabanına ekle (notifications kısmı kaldırıldı)
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, profile_photo, role) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->execute([$name, $email, $phone, $password_hash, $profile_photo_path]);

        header("Location: login.php");
        exit;
    }
}
?>

<h2 style="text-align:center;">Kayıt Ol</h2>

<div class="form-container">
    <?php if ($message): ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Ad Soyad:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label for="phone">Telefon:</label>
        <input type="text" name="phone" id="phone" pattern="^\d{10}$" maxlength="10" required title="Lütfen geçerli bir telefon numarası girin (10 haneli)">

        <label>Şifre:</label>
        <input type="password" name="password" required>

        <label>Şifre Tekrar:</label>
        <input type="password" name="confirm_password" required>

        <label>Profil Fotoğrafı:</label>
        <input type="file" name="profile_photo">

        <button type="submit">Kayıt Ol</button>
    </form>

    <p>Hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
</div>

<?php include('includes/footer.php'); ?>
