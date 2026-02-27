<?php
$pageTitle = 'Delete Student';
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['nic']) || empty($_GET['nic'])) {
    header('Location: search.php');
    exit;
}
$nic = $_GET['nic'];

$message = '';
$error = '';

$stmt = $conn->prepare("SELECT name FROM students WHERE nic = ?");
$stmt->bind_param("s", $nic);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('Location: search.php');
    exit;
}
$student = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $delete = $conn->prepare("DELETE FROM students WHERE nic = ?");
        $delete->bind_param("s", $nic);
        if ($delete->execute()) {
            $_SESSION['delete_message'] = "Student with NIC $nic has been deleted.";
            header('Location: search.php');
            exit;
        } else {
            $error = 'Deletion failed: ' . $conn->error;
        }
        $delete->close();
    } else {
        header('Location: search.php');
        exit;
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section>
        <h2 class="section-title">Confirm Deletion</h2>
        <div class="card" style="text-align: center;">
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: #ff4444; margin-bottom: 1rem;"></i>
            <h3>Are you sure?</h3>
            <p>You are about to delete <strong><?php echo htmlspecialchars($student['name']); ?></strong> (NIC: <?php echo htmlspecialchars($nic); ?>).</p>
            <p style="color: var(--text-muted);">This action cannot be undone.</p>

            <form method="POST" action="" style="margin-top: 2rem;">
                <button type="submit" name="confirm" value="yes" class="btn btn-danger"><i class="fas fa-trash"></i> Yes, Delete</button>
                <a href="search.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </form>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>