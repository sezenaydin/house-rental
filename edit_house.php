<?php
session_start();
include('includes/config.php');
include('includes/header.php');

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ev ID'sini al
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: my_houses.php"); // Yönlendirme yap
    exit;
}

$house_id = $_GET['id'];

// Evin bilgilerini çek
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ? AND user_id = ?");
$stmt->execute([$house_id, $user_id]);
$house = $stmt->fetch();

if (!$house) {
    header("Location: my_houses.php"); // Ev bulunamazsa yönlendir
    exit;
}

// Düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Veritabanını güncelle
    $stmt = $pdo->prepare("UPDATE houses SET title = ?, price = ?, location = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $price, $location, $description, $house_id]);

    $_SESSION['success_message'] = "Ev başarıyla güncellendi!";
    header("Location: my_houses.php");
    exit;
}
?>

<div class="container mt-5 pt-4">
    <h2 class="text-center mb-4">Ev Düzenle</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Ev Başlığı</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($house['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Fiyat</label>
            <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($house['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Konum</label>
            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($house['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Açıklama</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($house['description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success w-100">Ev Bilgilerini Güncelle</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
