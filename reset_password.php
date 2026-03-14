<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';
$valid_token = false;
$email = '';

// Check if token exists
if (!isset($_GET['token']) && !isset($_POST['token'])) {
    die("Invalid request. Missing token.");
}

$token = isset($_GET['token']) ? $_GET['token'] : $_POST['token'];

// Validate token
$stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);

if ($stmt->rowCount() == 1) {
    $valid_token = true;
    $row = $stmt->fetch();
    $email = $row['email'];
}
else {
    $error = "This password reset token is invalid or has expired.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_token) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password)) {
        $error = "Please enter both fields.";
    }
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    }
    else {
        // Update password in users table
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        if ($stmt->execute([$password_hash, $email])) {
            // Delete token
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            $_SESSION['success_msg'] = "Your password has been successfully reset. You can now login.";
            header("Location: index.php");
            exit;
        }
        else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="auth-container">
    <h2>Create New Password</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php
endif; ?>
    
    <?php if ($valid_token): ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="resetForm">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            
            <button type="submit" class="submit-btn">Update Password</button>
        </form>
    <?php
endif; ?>

    <?php if (!$valid_token && !empty($error)): ?>
        <div class="links">
            <a href="forgot_password.php">Request a new reset link</a>
        </div>
    <?php
endif; ?>
</div>

<?php include 'footer.php'; ?>
