<?php
$pageTitle = 'Edit Student';
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

$stmt = $conn->prepare("SELECT * FROM students WHERE nic = ?");
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
    $name = trim($_POST['name'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if (empty($name) || empty($gender) || empty($address) || empty($contact) || empty($email) || empty($course)) {
        $error = 'All fields are required.';
    } else {
        $update = $conn->prepare("UPDATE students SET name=?, gender=?, address=?, contact=?, email=?, course=? WHERE nic=?");
        $update->bind_param("sssssss", $name, $gender, $address, $contact, $email, $course, $nic);
        if ($update->execute()) {
            $message = 'Student details updated successfully.';
            // Refresh student data
            $student['name'] = $name;
            $student['gender'] = $gender;
            $student['address'] = $address;
            $student['contact'] = $contact;
            $student['email'] = $email;
            $student['course'] = $course;
        } else {
            $error = 'Update failed: ' . $conn->error;
        }
        $update->close();
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section>
        <h2 class="section-title">Edit Student</h2>
        <p class="section-subtitle">NIC: <?php echo htmlspecialchars($nic); ?></p>

        <div class="card">
            <?php if ($message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <p><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $student['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact"><i class="fas fa-phone"></i> Contact Number</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="course"><i class="fas fa-graduation-cap"></i> Course</label>
                    <select id="course" name="course" required>
                        <option value="Diploma in IT" <?php echo $student['course'] == 'Diploma in IT' ? 'selected' : ''; ?>>Diploma in IT</option>
                        <option value="Diploma in Business" <?php echo $student['course'] == 'Diploma in Business' ? 'selected' : ''; ?>>Diploma in Business</option>
                        <option value="Certificate in English" <?php echo $student['course'] == 'Certificate in English' ? 'selected' : ''; ?>>Certificate in English</option>
                        <option value="Bachelor of IT" <?php echo $student['course'] == 'Bachelor of IT' ? 'selected' : ''; ?>>Bachelor of IT</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Student</button>
                <a href="search.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </form>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>