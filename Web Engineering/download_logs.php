<?php
session_start();

if (!isset($_SESSION['email'])) {
    die('User not logged in.');
}

$user_email = $_SESSION['email'];
$format = $_GET['format'] ?? 'txt';

// Database connection
$host = 'localhost';
$dbname = 'logs';
$username = 'hackerssg';
$password = 'crlf';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user logs
    $stmt = $pdo->prepare("SELECT * FROM user_logs WHERE email = :email ORDER BY timestamp DESC");
    $stmt->execute(['email' => $user_email]);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle file formats
    if ($format === 'json') {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="logs.json"');
        echo json_encode($logs);
    } elseif ($format === 'txt') {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="logs.txt"');
        foreach ($logs as $log) {
            echo "ID: {$log['id']}\tTool: {$log['tool_used']}\tCommand: {$log['input_command']}\tTimestamp: {$log['timestamp']}\n";
        }
    } elseif ($format === 'pdf') {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="logs.pdf"');

        // Example PDF generation (you may need a library like FPDF or TCPDF)
        echo "PDF generation not implemented yet.";
    } else {
        echo "Invalid format.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
