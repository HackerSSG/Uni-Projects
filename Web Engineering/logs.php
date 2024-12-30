<?php
session_start();

// Check if the user is logged in (email is set in session)
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your history.";
    exit;
}

// Get the logged-in user's email
$user_email = $_SESSION['email'];

// Database connection (adjust with your database credentials)
$host = 'localhost';
$dbname = 'logs';
$username = 'hackerssg';
$password = 'crlf';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch logs based on the user's email
    $stmt = $pdo->prepare("SELECT * FROM user_logs WHERE email = :email ORDER BY timestamp DESC");
    $stmt->execute(['email' => $user_email]);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Return the logs as a JSON object
echo json_encode($logs);
?>
