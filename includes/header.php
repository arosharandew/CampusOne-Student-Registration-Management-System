<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusOne - <?php echo $pageTitle ?? 'Home'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/CampusOne/assets/css/style.css">
</head>
<body>
    <div class="floating-icons" id="floating-icons"></div>
    <div class="network-lines"></div>
    <div class="particles" id="particles"></div>

    <div class="wrapper">
        <nav class="navbar">
            <div class="container">
                <h1 class="logo-text">CampusOne</h1>
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <div class="menu-toggle"><i class="fas fa-bars"></i></div>
                <ul class="nav-links">
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <li><a href="search.php"><i class="fas fa-search"></i> Search</a></li>
                    <li><a href="view_all.php"><i class="fas fa-list"></i> View All</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
                <?php endif; ?>
            </div>
        </nav>
        <main class="main-content">