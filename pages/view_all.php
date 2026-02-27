<?php
$pageTitle = 'All Students';
require_once '../includes/config.php';

// Check login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Fetch all students from database
$result = $conn->query("SELECT * FROM students ORDER BY name ASC");
$students = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
$total_students = count($students);
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section>
        <h2 class="section-title">All Registered Students</h2>
        <p class="section-subtitle">Total: <?php echo $total_students; ?> students enrolled</p>

        <div class="card">
            <?php if ($total_students > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>NIC</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['nic']); ?></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                <td><?php echo htmlspecialchars($student['contact']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['course']); ?></td>
                                <td>
                                    <a href="edit.php?nic=<?php echo urlencode($student['nic']); ?>" class="btn btn-small btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="delete.php?nic=<?php echo urlencode($student['nic']); ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this student?');"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: var(--text-muted); text-align: center;">No students registered yet.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>