<?php
include 'includes/config.php';
include('includes/header.php');

if (!isset($_GET['house_id'])) {
    header("Location: index.php");
    exit();
}

$houseId = $_GET['house_id'];

// Veritabanından sadece verilen ID'ye sahip evi çekiyoruz
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :house_id AND status = 'available'");
$stmt->bindParam(':house_id', $houseId, PDO::PARAM_INT);
$stmt->execute();
$house = $stmt->fetch(PDO::FETCH_ASSOC);

// Eğer ev bulunamazsa, hata mesajı veriyoruz
if (!$house) {
    die("Ev bulunamadı.");
}
?>

<!DOCTYPE html> 
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ev Detayları</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body { 
            font-family: Arial, sans-serif; 
            background: #f1f1f1; 
            margin: 0;
        }
        .page-content {
            margin-top: 80px; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .checkout-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            padding: 30px;
            display: flex;
            flex-direction: row;
            gap: 30px;
        }
        .house-details {
            flex: 1;
        }
        .house-img { 
            width: 100%; 
            max-height: 400px; 
            object-fit: cover; 
            border-radius: 10px; 
            margin-bottom: 20px;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        .house-info p { 
            font-size: 16px; 
            line-height: 1.6; 
            color: #555;
            margin: 6px 0;
        }
        .house-info strong { 
            color: #111;
        }
        .btn-pay { 
            display: inline-block; 
            margin-top: 25px; 
            padding: 14px 28px; 
            background: #007bff; 
            color: white; 
            border: none; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 16px; 
            transition: background 0.3s ease;
        }
        .btn-pay:hover { 
            background: #0056b3; 
        }
        @media (max-width: 768px) {
            .checkout-container {
                flex-direction: column;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="page-content">
        <div class="checkout-container">
            <div class="house-details">
                <h2><?php echo htmlspecialchars($house['title']); ?></h2>
                
                <?php if ($house['image']): ?>
                    <img src="<?php echo htmlspecialchars($house['image']); ?>" alt="Ev Görseli" class="house-img">
                <?php endif; ?>

                <div class="house-info">
                    <p><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($house['description'])); ?></p>
                    <p><strong>Fiyat:</strong> ₺<?php echo number_format($house['price'], 2, ',', '.'); ?></p>
                    
                    <?php if (!empty($house['location'])): ?>
                        <p><strong>Konum:</strong> <?php echo htmlspecialchars($house['location']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($house['size'])): ?>
                        <p><strong>Metrekare:</strong> <?php echo htmlspecialchars($house['size']); ?> m²</p>
                    <?php endif; ?>

                    <?php if (!empty($house['bedrooms'])): ?>
                        <p><strong>Yatak Odası:</strong> <?php echo $house['bedrooms']; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($house['bathrooms'])): ?>
                        <p><strong>Banyo:</strong> <?php echo $house['bathrooms']; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($house['year_built'])): ?>
                        <p><strong>Yapım Yılı:</strong> <?php echo $house['year_built']; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($house['features'])): ?>
                        <p><strong>Özellikler:</strong> <?php echo htmlspecialchars($house['features']); ?></p>
                    <?php endif; ?>
                </div>

                <a href="process-payment.php?house_id=<?= $house['id'] ?>" class="btn-pay">Ödeme Sayfasına Git</a>
            </div>
        </div>
    </div>

</body>
</html>
