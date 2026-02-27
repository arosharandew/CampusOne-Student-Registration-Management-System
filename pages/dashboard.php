<?php
$pageTitle = 'Dashboard';
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

$student_count = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section class="dashboard">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-subtitle">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>

        <div class="card">
            <div style="display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center;">
                <div class="stat-card">
                    <h3><i class="fas fa-users"></i> Total Students</h3>
                    <p><?php echo $student_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-calendar-alt"></i> Today's Date</h3>
                    <p><?php echo date('M d, Y'); ?></p>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-chart-line"></i> Active Courses</h3>
                    <p>4</p>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>Quick Actions</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.5rem;">
                <a href="register.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register New Student</a>
                <a href="search.php" class="btn btn-secondary"><i class="fas fa-search"></i> Search Students</a>
            </div>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>