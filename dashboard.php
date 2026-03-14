<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data for profile viewing
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    // Session exists but user not found in DB
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h2>Dashboard</h2>
        <div>
            <a href="logout.php" class="btn-secondary" style="border-color: var(--error-color); color: var(--error-color);">Logout</a>
        </div>
    </div>
    
    <div style="margin-bottom: 2rem;">
        <h3 style="margin-top: 0;">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h3>
        <p style="color: var(--text-secondary);">Here is your profile information.</p>
    </div>

    <div style="background: var(--bg-color); padding: 1.5rem; border-radius: 0.5rem;">
        <div style="margin-bottom: 1rem;">
            <strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?>
        </div>
        <div style="margin-bottom: 1rem;">
            <strong>Email Address:</strong> <?php echo htmlspecialchars($user['email']); ?>
        </div>
        <div>
            <strong>Member Since:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at']))); ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
