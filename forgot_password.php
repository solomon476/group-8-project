<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error = "Please enter your email.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            // Generate secure random token
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Delete old tokens for this email
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            // Insert new token
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$email, $token, $expires_at]);

            // In a real application, you would send an email here using mail() or a library like PHPMailer.
            // For this project, we'll simulate it by displaying the reset link.
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;

            $success = "A password reset link has been sent to your email. <br><br> <strong>Simulation:</strong> <a href='$reset_link'>Click here to reset your password</a>";
        }
        else {
            // For security, do not reveal if email exists or not in production
            $success = "If the email is registered, a password reset link will be sent.";
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="auth-container">
    <h2>Reset Password</h2>
    <p style="text-align: center; color: var(--text-secondary); margin-bottom: 1.5rem;">Enter your email to receive a password reset link.</p>
    
    <?php if (!empty($error)): ?>
        <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php
endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php
else: ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>
            </div>
            
            <button type="submit" class="submit-btn">Send Reset Link</button>
        </form>
    <?php
endif; ?>

    <div class="links" style="margin-top: 1.5rem; text-align: center;">
        <a href="index.php">Back to Login</a>
    </div>
</div>

<?php include 'footer.php'; ?>
