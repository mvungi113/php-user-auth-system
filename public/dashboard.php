<?php
require __DIR__ . '/../src/bootstrap.php';

// Require login to access dashboard
require_login();

$username = $_SESSION['username'] ?? 'User';
$is_admin = $_SESSION['is_admin'] ?? false;

view('dashboard_header', ['title' => 'Dashboard']);
?>

<main class="dashboard">
    <div class="user-info-card">
        <h2>User Information</h2>
        <div class="info-row">
            <span class="label">Username:</span>
            <span class="value"><?= htmlspecialchars($username) ?></span>
        </div>
        <div class="info-row">
            <span class="label">Account Type:</span>
            <span class="value"><?= $is_admin ? 'Administrator' : 'Regular User' ?></span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value status-active">Active</span>
        </div>
    </div>
</main>

<?php view('footer'); ?>
