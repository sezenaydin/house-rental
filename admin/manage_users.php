<?php
session_start();
include('../includes/config.php');

// Admin yetkisi kontrolü
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "house_rental");
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

// Kullanıcıları çek
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi | House Rental</title>
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

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
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

        .table-responsive {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .alert-warning {
            background-color: #f39c12;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions .btn {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .btn-info {
            background-color: #3498db;
            transition: background-color 0.3s ease;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-edit {
            background-color: #f39c12;
            padding: 8px 16px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #e67e22;
        }

        .btn-delete {
            background-color: #e74c3c;
            padding: 8px 16px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        #searchInput {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Kullanıcı Yönetimi</h2>

    <a href="./dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Panel'e Dönüş</a>

    <a href="add_user.php" class="button"><i class="fas fa-plus-circle"></i> Yeni Kullanıcı Ekle</a>

    <input type="text" id="searchInput" placeholder="Kullanıcı ara..." onkeyup="searchUsers()" class="form-control">

    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ad</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['full_name']); ?></td>

                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><span class="badge <?= ($row['role'] === 'admin') ? 'bg-danger' : 'bg-success'; ?>"><?= htmlspecialchars($row['role']); ?></span></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn-edit">Düzenle</a>
                        <a href="delete_user.php?id=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert-warning">
            Hiç kullanıcı kaydı bulunamadı.
        </div>
    <?php endif; ?>
</div>

</body>
</html>


<script>
    function searchUsers() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('userTableBody');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            // Ad, Email ve Rol sütunlarını kontrol et
            for (let j = 0; j < 3; j++) {
                if (cells[j].textContent.toUpperCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            if (match) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>

</body>
</html>
