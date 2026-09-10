<?php
$current_page = basename($_SERVER['PHP_SELF']);
$logged_in = isset($_SESSION['username']);
$username = $logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/bazaarjo/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Bazaarjo</h1>
                <span>Employee Portal</span>
            </div>
            <nav>
                <?php if($logged_in): ?>
                    <a href="/bazaarjo/dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a>
                    <a href="/bazaarjo/profile.php" class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">Profile</a>
                    <a href="/bazaarjo/upload.php" class="<?php echo $current_page == 'upload.php' ? 'active' : ''; ?>">Photo</a>
                    <a href="/bazaarjo/system.php" class="<?php echo $current_page == 'system.php' ? 'active' : ''; ?>">System</a>
                    <a href="/bazaarjo/announcements.php" class="<?php echo $current_page == 'announcements.php' ? 'active' : ''; ?>">Announcements</a>
                    <a href="/bazaarjo/search.php" class="<?php echo $current_page == 'search.php' ? 'active' : ''; ?>">Search</a>
                    <span class="user-info">Welcome, <?php echo htmlspecialchars($username); ?></span>
                    <a href="/bazaarjo/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/bazaarjo/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>
