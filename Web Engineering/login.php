<?php
session_start();

// Database configuration
$host = 'localhost';           // Database host
$dbname = 'user';              // Database name
$username = 'hackerssg';       // Database username
$password = 'crlf';            // Database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password']; // Plain text password from the form
    $isAdmin = isset($_POST['adminLogin']) && $_POST['adminLogin'] === 'adminLogin';  // Check if admin login is selected

    if ($isAdmin) {
        // Admin login check
        if ($email === 'hackerssg@gmail.com' && $pass === '1234') {
            $_SESSION['username'] = 'Admin';  // Store admin info in session
            $_SESSION['email'] = $email;
            header("Location: dashboardadmin.php"); // Redirect to admin dashboard
            exit();
        } else {
            header("Location: /error/incorrect_password.html"); // Incorrect password page for admin
            exit();
        }
    } else {
        // User login
        // Prepare and bind
        $stmt = $conn->prepare("SELECT username, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $email, $stored_password); // Fetch stored password
            $stmt->fetch();

            // Compare plain-text password with stored password
            if ($pass === $stored_password) { // Direct plain-text comparison
                $_SESSION['username'] = $username;  // Store username in session
                $_SESSION['email'] = $email;        // Store email in session
                echo "Login successful!";
                header("Location: mydashboard.php"); // Redirect to user dashboard
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            header("Location: /error/user_not_exist.html");
            exit();
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
