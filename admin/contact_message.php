<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Veritabanından mesajları çekme
try {
    $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Mesajlar | House Rental</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 30px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        .button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .message-status {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
        }

        .pending {
            background-color: #f39c12;
        }

        .read {
            background-color: #27ae60;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>İletişim Formları</h1>

    <a href="./dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Panel'e Dönüş</a>

    <?php if (!empty($messages)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Adı</th>
                    <th>E-posta</th>
                    <th>Konu</th>
                    <th>Durum</th>
                    <th>Mesaj</th>
                    <th>Tarih</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo $message['id']; ?></td>
                        <td><?php echo $message['name']; ?></td>
                        <td><?php echo $message['email']; ?></td>
                        <td><?php echo $message['subject']; ?></td>
                        <td>
                            <span class="message-status <?php echo $message['status'] == 'pending' ? 'pending' : 'read'; ?>">
                                <?php echo ucfirst($message['status']); ?>
                            </span>
                        </td>
                        <td><?php echo substr($message['message'], 0, 50) . '...'; ?></td>
                        <td><?php echo $message['created_at']; ?></td>
                        <td><a href="mark_as_read.php?id=<?php echo $message['id']; ?>">Okundu olarak işaretle</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="error-message">Henüz mesaj yok.</p>
    <?php endif; ?>
</div>

</body>
</html>
