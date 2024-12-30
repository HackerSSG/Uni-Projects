<?php
session_start();

// Database credentials
$servername = "localhost"; // Replace with your server if it's different
$username = "hackerssg"; // Replace with your database username
$password = "crlf"; // Replace with your database password
$dbname = "user"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in (ensure session is active and user is authenticated by email)
if (!isset($_SESSION['email'])) {
    $_SESSION['error'] = 'You must be logged in to update settings.';
    header('Location: first_login.html');
    exit();
}

// Fetch the current email from session
$current_email = $_SESSION['email'];

// Handle form submission for email update
if (isset($_POST['new-email']) && !empty($_POST['new-email'])) {
    $new_email = trim($_POST['new-email']);
    
    // Check if the new email is different from the current email
    if ($new_email !== $current_email) {
        // Sanitize and validate email
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            // Check if email already exists in the database
            $query = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $new_email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $_SESSION['error'] = 'This email is already registered. Please choose a different one.';
                header('Location: mydashboard.php');
                exit();
            } else {
                // Update email in the database
                $update_query = "UPDATE users SET email = ? WHERE email = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param('ss', $new_email, $current_email);
                if ($update_stmt->execute()) {
                    $_SESSION['email'] = $new_email; // Update email in session
                    $_SESSION['message'] = 'Email updated successfully!';
                    header('Location: mydashboard.php');
                    exit();
                } else {
                    $_SESSION['error'] = 'Failed to update email. Please try again.';
                    header('Location: mydashboard.php');
                    exit();
                }
            }
        } else {
            $_SESSION['error'] = 'Please enter a valid email address.';
            header('Location: mydashboard.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'New email cannot be the same as the current email.';
        header('Location: mydashboard.php');
        exit();
    }
}

// Handle form submission for password update
if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if the new password and confirm password match
    if ($new_password === $confirm_password) {
        // Fetch the stored password from the database
        $password_query = "SELECT password FROM users WHERE email = ?";
        $password_stmt = $conn->prepare($password_query);
        $password_stmt->bind_param('s', $current_email);
        $password_stmt->execute();
        $password_stmt->bind_result($stored_password);
        $password_stmt->fetch();

        // Compare the entered current password with the stored password
        if ($current_password === $stored_password) {
            // Update the password in the database
            $update_password_query = "UPDATE users SET password = ? WHERE email = ?";
            $update_password_stmt = $conn->prepare($update_password_query);
            $update_password_stmt->bind_param('ss', $new_password, $current_email);

            if ($update_password_stmt->execute()) {
                $_SESSION['message'] = 'Password updated successfully!';
                header('Location: mydashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to update password. Please try again.';
                header('Location: mydashboard.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Current password is incorrect.';
            header('Location: mydashboard.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'New password and confirm password do not match.';
        header('Location: mydashboard.php');
        exit();
    }
}
?>
