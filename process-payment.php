<?php
ob_start();
session_start();
include 'includes/config.php';
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Ev ID'si kontrolü
if (!isset($_GET['house_id']) && !isset($_POST['house_id'])) {
    header("Location: index.php");
    exit();
}

$houseId = $_GET['house_id'] ?? $_POST['house_id'];

// Ev detaylarını al
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = :house_id");
$stmt->bindParam(':house_id', $houseId, PDO::PARAM_INT);
$stmt->execute();
$house = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$house) {
    die("Ev bulunamadı.");
}

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate   = $_POST['start_date'];
    $endDate     = $_POST['end_date'];
    $fullName    = $_POST['full_name'];
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $cardNumber  = $_POST['card_number'];
    $expiryDate  = $_POST['expiry_date'];
    $cvv         = $_POST['cvv'];

    try {
        // Ödeme kaydı
        $stmt = $pdo->prepare("INSERT INTO payments (user_id, house_id, full_name, email, phone, card_number, expiry_date, cvv) VALUES (:user_id, :house_id, :full_name, :email, :phone, :card_number, :expiry_date, :cvv)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':house_id', $houseId);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':card_number', $cardNumber);
        $stmt->bindParam(':expiry_date', $expiryDate);
        $stmt->bindParam(':cvv', $cvv);
        $stmt->execute();

        // Kiralama kaydı
        $stmt_rental = $pdo->prepare("INSERT INTO rentals (house_id, user_id, start_date, end_date) VALUES (:house_id, :user_id, :start_date, :end_date)");
        $stmt_rental->bindParam(':house_id', $houseId);
        $stmt_rental->bindParam(':user_id', $userId);
        $stmt_rental->bindParam(':start_date', $startDate);
        $stmt_rental->bindParam(':end_date', $endDate);
        $stmt_rental->execute();

        // Evi kiralandı olarak güncelle
        $stmt_update = $pdo->prepare("UPDATE houses SET status = 'rented' WHERE id = :house_id");
        $stmt_update->bindParam(':house_id', $houseId);
        $stmt_update->execute();

        header("Location: payment-success.php?house_id=" . $houseId);
        exit();
        $update = $pdo->prepare("UPDATE houses SET status = 'rented' WHERE id = :house_id");
        $update->execute(['house_id' => $houseId]);

    } catch (PDOException $e) {
        die("Hata oluştu: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Ev Kiralama - Ödeme</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f0f2f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .payment-container {
      max-width: 800px;
      margin: 40px auto;
      background: white;
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 6px 24px rgba(0,0,0,0.1);
    }
    .step-title {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 25px;
      color: #2c3e50;
    }
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
    }
    .form-section {
      display: none;
    }
    .form-section.active {
      display: block;
    }
    .form-navigation {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    .form-navigation .btn {
      width: 48%;
    }
    #btn-submit {
      display: none;
    }
  </style>
</head>
<body>

<div class="container payment-container">
  <form id="paymentForm" method="POST" action="process-payment.php">
    <input type="hidden" name="house_id" value="<?php echo htmlspecialchars($houseId); ?>">

    <!-- Adım 1 -->
    <div class="form-section active" id="section-1">
      <h4 class="step-title"><i class="fas fa-calendar-alt me-2"></i>Kiralama Tarihleri</h4>
      <div class="mb-3">
        <label for="start_date" class="form-label">Başlangıç Tarihi</label>
        <input type="date" id="start_date" name="start_date" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="end_date" class="form-label">Bitiş Tarihi</label>
        <input type="date" id="end_date" name="end_date" class="form-control" required>
      </div>
    </div>

    <!-- Adım 2 -->
    <div class="form-section" id="section-2">
      <h4 class="step-title"><i class="fas fa-user me-2"></i>Kişisel Bilgiler</h4>
      <div class="row">
        <div class="mb-3 col-md-6">
          <label for="full_name" class="form-label">Ad Soyad</label>
          <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="email" class="form-label">E-posta</label>
          <input type="email" name="email" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Telefon</label>
        <input type="tel" name="phone" class="form-control" required>
      </div>
    </div>

    <!-- Adım 3 -->
    <div class="form-section" id="section-3">
      <h4 class="step-title"><i class="fas fa-credit-card me-2"></i>Ödeme Bilgileri</h4>
      <div class="mb-3">
        <label for="card_number" class="form-label">Kredi Kartı Numarası</label>
        <input type="text" name="card_number" class="form-control" placeholder="XXXX XXXX XXXX XXXX" required>
      </div>
      <div class="row">
        <div class="mb-3 col-md-6">
          <label for="expiry_date" class="form-label">Son Kullanma Tarihi</label>
          <input type="month" name="expiry_date" class="form-control" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="cvv" class="form-label">CVV</label>
          <input type="text" name="cvv" class="form-control" placeholder="XXX" required>
        </div>
      </div>
      <div class="form-check mt-3">
        <input class="form-check-input" type="checkbox" id="accept_terms" required>
        <label class="form-check-label" for="accept_terms">
          Kullanıcı Sözleşmesi ve Gizlilik Politikasını kabul ediyorum.
        </label>
      </div>
    </div>

    <!-- Butonlar -->
    <div class="form-navigation">
      <button type="button" class="btn btn-outline-secondary" id="btn-prev">Geri</button>
      <button type="button" class="btn btn-primary" id="btn-next">İleri</button>
    </div>

    <button type="submit" class="btn btn-success w-100 mt-4" id="btn-submit">
      <i class="fas fa-lock me-2"></i>Ödemeyi Tamamla
    </button>
  </form>
</div>

<script>
  window.onload = () => {
    const today = new Date().toISOString().split('T')[0];
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);

    startDateInput.addEventListener('change', () => {
      const selectedStartDate = startDateInput.value;
      endDateInput.value = '';
      endDateInput.setAttribute('min', selectedStartDate);
    });
  };

  const sections = document.querySelectorAll('.form-section');
  const btnPrev = document.getElementById('btn-prev');
  const btnNext = document.getElementById('btn-next');
  const btnSubmit = document.getElementById('btn-submit');
  let current = 0;

  function updateForm() {
    sections.forEach((section, i) => {
      section.classList.toggle('active', i === current);
    });

    btnPrev.disabled = current === 0;
    btnNext.style.display = current === sections.length - 1 ? 'none' : 'inline-block';
    btnSubmit.style.display = current === sections.length - 1 ? 'inline-block' : 'none';
  }

  btnNext.addEventListener('click', () => {
    if (!validateSection(sections[current])) return;
    if (current < sections.length - 1) current++;
    updateForm();
  });

  btnPrev.addEventListener('click', () => {
    if (current > 0) current--;
    updateForm();
  });

  function validateSection(section) {
    const inputs = section.querySelectorAll('input[required]');
    for (let input of inputs) {
      if (!input.value.trim()) {
        alert("Lütfen tüm alanları doldurun.");
        input.focus();
        return false;
      }
    }

    const checkbox = section.querySelector('input[type="checkbox"]');
    if (checkbox && !checkbox.checked) {
      alert("Lütfen sözleşmeyi kabul edin.");
      return false;
    }

    return true;
  }

  updateForm();
</script>

</body>
</html>
