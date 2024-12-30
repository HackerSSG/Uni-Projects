<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$log_id = intval($_GET['id']);
$user_email = $_SESSION['email'];

// Database connection
$host = 'localhost';
$dbname = 'logs';
$username = 'hackerssg';
$password = 'crlf';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete the log only if it belongs to the logged-in user
    $stmt = $pdo->prepare("DELETE FROM user_logs WHERE id = :id AND email = :email");
    $stmt->execute(['id' => $log_id, 'email' => $user_email]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
