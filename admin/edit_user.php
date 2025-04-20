<?php
session_start();
include('../includes/config.php');

// Kullanıcı ID'si URL'den alınır
$userId = $_GET['id'] ?? null;

if (!$userId) {
    die("Kullanıcı ID bulunamadı.");
}

// Kullanıcı bilgileri çekilir
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Kullanıcı bulunamadı.");
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? 'user';

    $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=?, phone=?, role=? WHERE id=?");
    $success = $stmt->execute([$fullName, $email, $phone, $role, $userId]);

    if ($success) {
        // Başarılıysa yönlendirme
        header("Location: manage_users.php");
        exit;
    } else {
        $message = "Güncelleme başarısız oldu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcıyı Düzenle | House Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: sans-serif; }
        .form-container {
            max-width: 700px; background: white; padding: 30px;
            margin: 50px auto; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 { font-size: 28px; font-weight: bold; text-align: center; margin-bottom: 20px; }
        label { font-weight: 600; color: #333; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #ccc; }
        .button { background: #3498db; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; }
        .button:hover { background: #2980b9; }
        .message { text-align: center; font-weight: bold; color: green; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="form-container">
    <a href="manage_users.php" class="button">&larr; Geri Dön</a>
    <h2>Kullanıcıyı Düzenle</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="full_name">Ad Soyad</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

        <label for="email">E-posta</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="phone">Telefon</label>
        <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">

        <label for="role">Rol</label>
        <select name="role" id="role" required>
            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>

        <button type="submit" class="button">Güncelle</button>
    </form>
</div>
</body>
</html>
