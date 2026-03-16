<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    }
    else {
        // Fetch user from db
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();

            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct, prevent session fixation
                session_regenerate_id(true);

                // Store data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['login_success'] = "This project has been worked on by solomon and his peers";

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit;
            }
            else {
                $error = "Invalid email or password.";
            }
        }
        else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="auth-container">
    <h2>Welcome Back</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php
endif; ?>
    
    <!-- Display success message when redirected from register or reset password -->
    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="alert success"><?php echo htmlspecialchars($_SESSION['success_msg']); ?></div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php
endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <button type="submit" class="submit-btn">Login</button>
    </form>

    <div class="links" style="display: flex; justify-content: space-between; margin-top: 1.5rem;">
        <a href="forgot_password.php">Forgot Password?</a>
        <a href="register.php">Create an Account</a>
    </div>
</div>

<?php include 'footer.php'; ?>
