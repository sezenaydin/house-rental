<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include('includes/config.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$success_message = "";
$error_messages = [];

// Profil Fotoğrafı
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_photo'])) {
    $file = $_FILES['profile_photo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $check = getimagesize($file['tmp_name']);

    if ($check && in_array($check['mime'], $allowedTypes)) {
        $fileName = 'uploads/' . uniqid() . '-' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $fileName)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
            $stmt->execute([$fileName, $user_id]);
            $success_message = "Profil fotoğrafı güncellendi.";
        } else {
            $error_messages[] = "Dosya yüklenemedi.";
        }
    } else {
        $error_messages[] = "Geçersiz dosya türü.";
    }
}

// Bilgi Güncelleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_account'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    $stmt = $pdo->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
    $stmt->execute([$name, $phone, $user_id]);
    $success_message = "Hesap bilgileri güncellendi.";
}

// Şifre Değiştir
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $error_messages[] = "Yeni şifreler eşleşmiyor.";
    } elseif (!password_verify($current, $user['password'])) {
        $error_messages[] = "Mevcut şifre yanlış.";
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $user_id]);
        $success_message = "Şifre başarıyla değiştirildi.";
    }
}

// Hesap Silme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_account'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Hesap Ayarları</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .profile-img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
    }
    .password-strength {
      height: 5px;
      margin-top: -10px;
    }
  </style>
</head>
<body>
<div class="container mt-5 mb-5 d-flex justify-content-center">
  <div style="width: 100%; max-width: 500px;">
    <h3 class="mb-4 text-center">Hesap Ayarları</h3>

    <!-- Geri Bildirim -->
    <?php if ($success_message): ?>
      <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    <?php foreach ($error_messages as $msg): ?>
      <div class="alert alert-danger"><?= $msg ?></div>
    <?php endforeach; ?>

    <ul class="nav nav-tabs justify-content-center mb-3" id="settingsTab" role="tablist">
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profil</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Şifre</button>
      </li>
      <li class="nav-item">
        <button class="nav-link text-danger" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab">Hesabı Sil</button>
      </li>
    </ul>

    <div class="tab-content border p-4 rounded shadow-sm">
      <!-- Profil Bilgileri -->
      <div class="tab-pane fade show active" id="profile" role="tabpanel">
        <div class="text-center mb-3">
          <img src="<?= !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'assets/images/default-avatar.png' ?>" class="profile-img mb-2">
          <form method="post" enctype="multipart/form-data">
            <input type="file" name="profile_photo" class="form-control mb-2" accept="image/*">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Yükle</button>
          </form>
        </div>

        <form method="post">
          <input type="hidden" name="update_account" value="1">
          <div class="mb-3">
            <label>Ad Soyad</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
          </div>
          <div class="mb-3">
            <label>Telefon</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Güncelle</button>
        </form>
      </div>

      <!-- Şifre Değiştir -->
      <div class="tab-pane fade" id="password" role="tabpanel">
        <form method="post">
          <input type="hidden" name="change_password" value="1">
          <div class="mb-3">
            <label>Mevcut Şifre</label>
            <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Yeni Şifre</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <div class="progress password-strength mt-1">
              <div id="strengthBar" class="progress-bar" role="progressbar"></div>
            </div>
          </div>
          <div class="mb-3">
            <label>Yeni Şifre (Tekrar)</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-warning"><i class="fa fa-key"></i> Şifreyi Değiştir</button>
        </form>
      </div>

      <!-- Hesabı Sil -->
      <div class="tab-pane fade" id="delete" role="tabpanel">
        <form method="post">
          <input type="hidden" name="delete_account" value="1">
          <p class="text-danger">Hesabınızı silmek üzeresiniz. Bu işlem geri alınamaz.</p>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hesabımı Sil</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Şifre gücü göstergesi
document.getElementById('new_password').addEventListener('input', function () {
  const val = this.value;
  const bar = document.getElementById('strengthBar');
  let strength = 0;
  if (val.length > 5) strength++;
  if (val.match(/[A-Z]/)) strength++;
  if (val.match(/[0-9]/)) strength++;
  if (val.match(/[^a-zA-Z0-9]/)) strength++;

  const percent = (strength / 4) * 100;
  bar.style.width = percent + '%';
  bar.className = 'progress-bar';

  if (percent < 40) bar.classList.add('bg-danger');
  else if (percent < 70) bar.classList.add('bg-warning');
  else bar.classList.add('bg-success');
});
</script>
</body>
</html>
