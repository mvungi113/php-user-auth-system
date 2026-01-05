<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link rel="stylesheet" href="/php/public/css/style.css">
    <link rel="stylesheet" href="/php/public/css/dashboard.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="header-container">
            <div class="logo">
                <h1>MyApp</h1>
            </div>
            <nav class="main-nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="profile.php">Profile</a>
                <a href="settings.php">Settings</a>
            </nav>
            <div class="user-menu">
                <span class="username-display"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>
    <?php flash(); ?>
