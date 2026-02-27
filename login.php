<?php
$pageTitle = 'Admin Login';
require_once 'includes/config.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: pages/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($username === 'Dulmini' && $password === 'Dulmini123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: pages/dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="login-container">
        <div class="card animate-on-load">
            <h2 class="section-title">Admin Login</h2>
            <p class="section-subtitle">Access the CampusOne management system</p>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>