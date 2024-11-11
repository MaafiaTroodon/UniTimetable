<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (login.php)
*/

include('../includes/header.php');
require_once '../includes/db.php'; // Include the database connection

// Start a session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare and execute the SQL statement using $mysqli
    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        // Plain-text password comparison (for demonstration purposes)
        if ($password === $stored_password) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');

            // Set a cookie for the last login time (30 days)
            setcookie('last_login_time', $_SESSION['login_time'], time() + (86400 * 30), "/");

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<h2 class="login-heading">Login</h2>
<div class="login-container">
    <form method="POST" action="login.php" class="login-form">
        <div class="mb-3">
            <label for="username" class="form-label login-label">Username</label>
            <input type="text" class="form-control login-input" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label login-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control login-input" id="password" name="password" required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
            </div>
        </div>
        <?php if (!empty($error)): ?>
            <p class="login-error"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit" class="btn btn-login">Login</button>
    </form>
</div>
<div class="view-schedule-container">
    <p>Want to view the course schedule without logging in?</p>
    <a href="index.php" class="btn-view-schedule">View Course Schedule</a>
</div>
<script>
// Show/Hide Password functionality
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordField = document.getElementById("password");
    const toggleButton = document.getElementById("togglePassword");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.textContent = "Hide";
    } else {
        passwordField.type = "password";
        toggleButton.textContent = "Show";
    }
});
</script>

<?php
include('../includes/footer.php');
?>