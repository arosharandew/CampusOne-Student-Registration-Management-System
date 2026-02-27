<?php
$pageTitle = 'Register Student';
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nic = trim($_POST['nic'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if (empty($nic) || empty($name) || empty($gender) || empty($address) || empty($contact) || empty($email) || empty($course)) {
        $error = 'All fields are required.';
    } else {
        $check = $conn->prepare("SELECT nic FROM students WHERE nic = ?");
        $check->bind_param("s", $nic);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $error = 'A student with this NIC already exists.';
        } else {
            $stmt = $conn->prepare("INSERT INTO students (nic, name, gender, address, contact, email, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nic, $name, $gender, $address, $contact, $email, $course);
            if ($stmt->execute()) {
                $message = 'Student registered successfully.';
            } else {
                $error = 'Registration failed: ' . $conn->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section>
        <h2 class="section-title">Register New Student</h2>
        <p class="section-subtitle">Fill in the details to add a student to the system</p>

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
                    <label for="nic"><i class="fas fa-id-card"></i> NIC Number</label>
                    <input type="text" id="nic" name="nic" placeholder="e.g., 123456789V" required>
                </div>
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="contact"><i class="fas fa-phone"></i> Contact Number</label>
                    <input type="text" id="contact" name="contact" placeholder="e.g., 0771234567" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" placeholder="student@example.com" required>
                </div>
                <div class="form-group">
                    <label for="course"><i class="fas fa-graduation-cap"></i> Course</label>
                    <select id="course" name="course" required>
                        <option value="">Select Course</option>
                        <option value="Diploma in IT">Diploma in IT</option>
                        <option value="Diploma in Business">Diploma in Business</option>
                        <option value="Certificate in English">Certificate in English</option>
                        <option value="Bachelor of IT">Bachelor of IT</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Register Student</button>
                <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </form>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>