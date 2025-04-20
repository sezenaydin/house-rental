<?php
require_once('../includes/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Rapor verileri
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_houses = $pdo->query("SELECT COUNT(*) FROM houses")->fetchColumn();
$total_rented = $pdo->query("SHOW TABLES LIKE 'rentals'")->rowCount() > 0
    ? $pdo->query("SELECT COUNT(*) FROM rentals")->fetchColumn()
    : 0;

$monthly_rentals_stmt = $pdo->query("SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) as total
                                      FROM rentals
                                      GROUP BY month
                                      ORDER BY month DESC
                                      LIMIT 6");

$monthly_rentals = $monthly_rentals_stmt->fetchAll(PDO::FETCH_ASSOC);

$months = array_reverse(array_column($monthly_rentals, 'month'));
$rent_counts = array_reverse(array_column($monthly_rentals, 'total'));


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Raporları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        .actions .btn {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .btn-info {
            background-color: #3498db;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>

</head>
<body>
<div class="container mt-5">
<a href="./dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Panel'e Dönüş</a>
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Admin Paneli - Genel Performans</h4>
        </div>
        <div class="card-body">
            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Toplam Kullanıcı</h5>
                            <h3 class="fw-bold"><?= $total_users ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Toplam Ev</h5>
                            <h3 class="fw-bold"><?= $total_houses ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"> Kiralanan Evler</h5>
                            <h3 class="fw-bold"><?= $total_rented ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3 text-center">Aylık Kiralamalar</h5>
            <canvas id="rentalChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('rentalChart').getContext('2d');
    const rentalChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: 'Kiralanan Evler',
                data: <?= json_encode($rent_counts) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'blue'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
</body>
</html>
