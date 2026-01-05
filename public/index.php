<?php
require __DIR__ . '/../src/bootstrap.php';

// Check if user is logged in
if (is_user_logged_in()) {
    $username = $_SESSION['username'] ?? 'User';
    $is_admin = $_SESSION['is_admin'] ?? false;
} else {
    $username = null;
}

view('header', ['title' => 'Home']);
?>

<main>
    <?php if ($username): ?>
        <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <p>You are successfully logged in.</p>
        
        <?php if ($is_admin): ?>
            <p><strong>Admin Access Granted</strong></p>
        <?php endif; ?>
        
        <div>
            <a href="logout.php">Logout</a>
        </div>
    <?php else: ?>
        <h1>Welcome to Our Application</h1>
        <p>Please login or register to continue.</p>
        
        <div>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    <?php endif; ?>
</main>

<?php view('footer'); ?>
