<?php
$pageTitle = 'Search Students';
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

$results = [];
$search_term = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM students WHERE nic LIKE ? OR name LIKE ?");
    $like_term = "%$search_term%";
    $stmt->bind_param("ss", $like_term, $like_term);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}

// Display delete message if set
$delete_message = $_SESSION['delete_message'] ?? '';
unset($_SESSION['delete_message']);
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <section>
        <h2 class="section-title">Search Students</h2>
        <p class="section-subtitle">Find a student by NIC or name</p>

        <?php if ($delete_message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <p><?php echo htmlspecialchars($delete_message); ?></p>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="GET" action="" class="search-box">
                <input type="text" name="search" placeholder="Enter NIC or Name..." value="<?php echo htmlspecialchars($search_term); ?>" required>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>

            <?php if ($search_term !== ''): ?>
                <h3>Results for "<?php echo htmlspecialchars($search_term); ?>"</h3>
                <?php if (count($results) > 0): ?>
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
                                <?php foreach ($results as $student): ?>
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
                    <p style="color: var(--text-muted);">No students found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>