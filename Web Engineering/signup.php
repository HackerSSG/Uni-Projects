<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password']; // Storing password in plain text
    $confirm_password = $_POST['confirm_password'];

    // Establish database connection
    $conn = new mysqli('localhost', 'hackerssg', 'crlf', 'user');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $email_check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $email_check->bind_param("s", $email);
    $email_check->execute();
    $result = $email_check->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, redirect to error page
        header("Location: error/email_exists_error.html");
        exit();
    }

    // Check if the passwords match
    if ($password === $confirm_password) {
        // Email is unique, proceed with signup
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password); // Insert the password as plain text

        if ($stmt->execute()) {
            // Start session and store user details
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;

            // Redirect to the dashboard after successful signup
            header("Location: mydashboard.php");
            exit();
        } else {
            // Redirect to an error page or handle the error
            header("Location: error.html");
            exit();
        }

        $stmt->close();
    } else {
        // Passwords do not match, redirect to error page
        header("Location: /error/password_error.html");
        exit();
    }

    // Close database connection
    $email_check->close();
    $conn->close();
}
?>
