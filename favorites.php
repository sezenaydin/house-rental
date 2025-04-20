<?php
include('includes/config.php');
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT h.*
    FROM houses h
    JOIN favorites f ON h.id = f.house_id
    WHERE f.user_id = ?
    ORDER BY f.created_at DESC
");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Favorilerim</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 80px; /* navbar yüksekliğine göre ayarla */

        }

        .favorites-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            flex: 1; /* Sayfa içeriği fazla olsa bile footer'ı alt kısımda tutar */
        }
        .favorite-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .favorite-card:hover {
            transform: translateY(-5px);
        }
        .favorite-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .favorite-card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }
        .favorite-card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }
        .favorite-card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }
        .favorite-card a {
            display: inline-block;
            margin-top: 10px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        .favorite-card a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Sayfa içeriği boş olsa bile footer'ı en alta iter */
        }
        .favorites-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
        }

        .favorites-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px; /* Ortalamak için sabit bir genişlik */
            width: 100%;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center; margin-top: 100px;">Favorilerim</h1>


    <div class="favorites-wrapper">
        <div class="favorites-container">
            <?php if (count($favorites) > 0): ?>
                <?php foreach ($favorites as $house): ?>
                    <div class="favorite-card">
                        <h3><?php echo htmlspecialchars($house['title']); ?></h3>
                        <?php if (!empty($house['image'])): ?>
                            <img src="<?php echo htmlspecialchars($house['image']); ?>" alt="Ev Görseli">
                        <?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($house['description'])); ?></p>
                        <p class="price">Fiyat: ₺<?php echo number_format($house['price'], 2, ',', '.'); ?></p>
                        <a href="remove-favorite.php?house_id=<?php echo $house['id']; ?>">Favorilerden Kaldır</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #888;">Henüz favori eviniz yok.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php include('includes/footer.php'); ?>
