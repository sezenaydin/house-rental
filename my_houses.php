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

// Kullanıcının evlerini çek
$stmt = $pdo->prepare("SELECT * FROM houses WHERE user_id = ?");
$stmt->execute([$user_id]); // Bu satır eksikti!
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success text-center">
        <?php 
        echo $_SESSION['success_message']; 
        unset($_SESSION['success_message']); // sadece 1 kere göster
        ?>
    </div>
<?php endif; ?>
 
<div class="container mt-5 pt-4">
    <h2 class="text-center mb-4">Evlerim</h2>

    <?php if (count($houses) > 0): ?>
        <div class="row">
            <?php foreach ($houses as $house): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($house['image'])): ?>
                            <img src="<?php echo $house['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($house['title']); ?></h5>
                            <p class="card-text"><strong>Fiyat:</strong> ₺<?php echo number_format($house['price']); ?></p>
                            <p class="card-text"><strong>Konum:</strong> <?php echo htmlspecialchars($house['location']); ?></p>
                            <p class="card-text"><?php echo mb_strimwidth(htmlspecialchars($house['description']), 0, 100, '...'); ?></p>
                            <a href="edit_house.php?id=<?php echo $house['id']; ?>" class="btn btn-sm btn-outline-primary">Düzenle</a>
                            <a href="delete_house.php?id=<?php echo $house['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu evi silmek istediğinizden emin misiniz?')">Sil</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Henüz hiç ev eklemediniz. <a href="add-house.php">Buradan yeni bir ev ekleyin</a>.</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
