<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Get the logged-in user's email from the session
$user_email = $_SESSION['email'];

// Database connection
$host = 'localhost';
$dbname = 'logs';
$username = 'hackerssg';
$password = 'crlf';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch logs for the user
    $stmt = $pdo->prepare("SELECT * FROM user_logs WHERE email = :email ORDER BY timestamp DESC");
    $stmt->execute(['email' => $user_email]);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($logs);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
?>
