# Testing Report: Secure Login System

## 1. Functional Testing
Functional testing ensures that all specific features of the application operate according to the requirements.

| Feature Area | Test Scenario | Expected Result | Pass/Fail |
| :--- | :--- | :--- | :--- |
| **Registration** | Submit empty form | Validation error shown, form not submitted. | **Pass** |
| **Registration** | Submit mismatched passwords | Client/Server error "Passwords do not match". | **Pass** |
| **Registration** | Submit existing username/email | Server error "Username or email already exists". | **Pass** |
| **Registration** | Submit valid, unique credentials | DB insertion successful, redirect to login with success message. | **Pass** |
| **Login** | Submit invalid credentials | Server error "Invalid email or password" displayed. | **Pass** |
| **Login** | Submit valid credentials | Session created, user redirected to Dashboard. | **Pass** |
| **Dashboard** | Load dashboard after login | Displays correct Username, Email, and formatted Registration Date. | **Pass** |
| **Logout** | Click "Logout" button | User redirected to login, session destroyed. | **Pass** |
| **Auth Guard** | Access `dashboard.php` logged out | User instantly redirected back to `index.php`. | **Pass** |

## 2. Integration Testing
Integration testing verifies that the separate modules of the application (frontend HTML/JS, PHP backend, MySQL database) work seamlessly together.

- **Frontend-Backend Integration**: JavaScript correctly intercepts bad form data before hitting the server. Valid data is correctly POSTed to the PHP scripts.
- **Backend-Database Integration**: `config.php` utilizes PDO to successfully establish a stable connection to the MySQL database. `try...catch` blocks successfully handle connection and query exceptions, transforming them into readable PHP errors instead of crashing.
- **Session Transitions**: The transfer of state variables via `$_SESSION` across distinct files (`register.php` -> `index.php` -> `dashboard.php`) functions flawlessly, specifically in the seamless delivery of the "Registration successful" and "This project has been worked on by solomon and his peers" messages.

## 3. Security Testing
Security testing validates that the application resists basic malicious attacks and protects user data.

- **Password Hashing Validation**: Verified in the MySQL database that the `password_hash` column stores strings like `$2y$10$...` instead of plaintext passwords. This confirms `password_hash(..., PASSWORD_BCRYPT)` is working correctly.
- **SQL Injection Prevention**: All SQL queries utilize parameter binding (`$stmt->execute([$var1, $var2])`) rather than concatenating strings. This sanitizes inputs and eliminates standard SQL injection vulnerabilities.
- **Session Fixation**: Upon successful password verification in `index.php`, the system calls `session_regenerate_id(true)`. This prevents an attacker from supplying a known session ID to compromise an account.
- **XSS Prevention**: Any user data output to the HTML (e.g., error messages, usernames) is wrapped in `htmlspecialchars()` to prevent malicious scripts from rendering in the victim's browser.

## 4. Usability Testing
Usability testing evaluates the user interface and overall experience of using the system.

- **Interface Clarity**: The UI utilizes the modern 'Inter' font and standard CSS layout principles, making forms clear and readable.
- **Feedback Mechanisms**: Error messages (red) and success messages (green) are clear, contrasting against the form background, and immediately inform the user of the system state.
- **Error Gracefulness**: Implementing `try...catch` around PDO transactions ensures that if the database is unreachable, the user receives a clean HTML error inside the auth box rather than encountering an unstyled PHP fatal error that breaks the layout.
