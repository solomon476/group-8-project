# User Manual: Secure Login System

## Introduction
Welcome to the Secure Login System. This manual provides step-by-step instructions on how to install, configure, and use the system's core features.

## Table of Contents
1. [Configuration and Setup](#configuration-and-setup)
2. [How to Register a New User](#how-to-register-a-new-user)
3. [How to Log In](#how-to-log-in)
4. [How to View Your Profile](#how-to-view-your-profile)
5. [How to Reset Your Password](#how-to-reset-your-password)
6. [How to Log Out](#how-to-log-out)
7. [Troubleshooting Tips](#troubleshooting-tips)

---

## Configuration and Setup

To run this application locally using an environment like XAMPP:
1. Turn on the **Apache** and **MySQL** services in your XAMPP Control Panel.
2. Open phpMyAdmin (`http://localhost/phpmyadmin`) and create a new database named `group8` (or the name you prefer).
3. Import the `database.sql` file into your new database to generate the `users` and `password_resets` tables.
4. Copy the project folder into `c:\xampp\htdocs\group8`.
5. Open `config.php` and verify the database credentials (default XAMPP setup below):
```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'group8';
```
6. Navigate to `http://localhost/group8` in your browser.

---

## How to Register a New User

1. Navigate to the registration page (`register.php` or `register.html`).
2. Fill out the "Create an Account" form:
   - enter your desired **Username**.
   - enter a valid **Email Address**.
   - enter a strong **Password** (minimum length of 8 characters).
   - re-enter the password in the **Confirm Password** field.
3. Click the **Register** button.
4. If successful, you will be automatically redirected to the login page with a green success message: *"Registration successful! This project has been worked on by solomon and his peers. You can now login."*

*(Screenshot Placeholder: Registration Form UI)*
*(Screenshot Placeholder: Success Message Alert)*

---

## How to Log In

1. Navigate to the login page (`index.php`).
2. Under "Welcome Back", enter your registered **Email Address** and **Password*.
3. Click the **Login** button.
4. If your credentials are correct, you will be securely logged in and redirected to your Dashboard profile.
   - Note: If you enter an incorrect email or password, a red error alert will appear stating *"Invalid email or password."*

*(Screenshot Placeholder: Login Form UI)*

---

## How to View Your Profile

1. After successfully logging in, you will be taken to `dashboard.php`.
2. This page serves as your secure profile view. At the top, it will say "Welcome, [Your Username]!".
3. Upon your first login for a session, you will see a green alert: *"This project has been worked on by solomon and his peers"*.
4. Below that, your Profile Information card displays your:
   - **Username**
   - **Email Address**
   - **Member Since** (Formatted Timestamp of your registration)

*(Screenshot Placeholder: Secure Dashboard Profile UI)*

---

## How to Reset Your Password

1. Navigate to the login page (`index.php`).
2. Click the **Forgot Password?** link at the bottom of the card.
3. This sends you to `forgot_password.php`. Enter the email address associated with your account.
4. Click **Send Reset Link**.
5. Once a valid reset link/token is generated and navigated to (`reset_password.php`), enter your new password and confirm it.
6. Click **Reset Password**. Log in with the new credentials.

*(Screenshot Placeholder: Forgot Password Form UI)*

---

## How to Log Out

1. While logged into the dashboard (`dashboard.php`), locate the top right header area.
2. Click the **Logout** button (Secondary button outline with red text).
3. Your secure session will be instantly destroyed.
4. You will be redirected back to the login page (`index.php`), unable to access the dashboard until you log in again.

---

## Troubleshooting Tips

**Problem**: The page displays a "Database Error" inside a red box when I try to register.
**Solution**: This implies PHP cannot communicate with MySQL. Double-check your `config.php` file for typos in the `$db_host`, `$db_user`, `$db_pass`, or `$db_name` variables.

**Problem**: The "Create an Account" link on the `index.html` page says 404 Not Found.
**Solution**: This happens if the static `register.html` is missing or not synced with `register.php`. Ensure you are visiting `index.php` as your primary entry point, not `index.html`.

**Problem**: Passwords never match when registering, even if typed perfectly.
**Solution**: Ensure your browser auto-fill isn't inserting a different hidden password over your typed characters before hitting submit.

**Problem**: Getting stuck in a redirect loop on `dashboard.php`.
**Solution**: This occurs if the session exists but your user ID no longer matches a valid database record (e.g., deleted manually). Manually go to `logout.php` via URL to wipe the stray session variable.
