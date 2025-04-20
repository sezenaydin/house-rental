<?php

ob_start();    
    include('includes/config.php');
    include('includes/header.php');

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            // Admin veya normal kullanıcıyı yönlendir
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php"); // Admin paneline yönlendir
            } else {
                header("Location: index.php"); // Kullanıcı paneline yönlendir
            }
            exit;
        } else {
            $message = "Geçersiz email veya şifre.";
        }
    }
    ?>

    <h2 style="text-align:center;">Giriş Yap</h2>

    <div class="form-container">
        <?php if ($message): ?>
            <p style="color:red;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Şifre:</label>
            <input type="password" name="password" required>

            <button type="submit">Giriş Yap</button>
        </form>

        <p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p> <!-- Kayıt linki -->
    </div>

    <?php include('includes/footer.php'); ?>
ob_end_flush();