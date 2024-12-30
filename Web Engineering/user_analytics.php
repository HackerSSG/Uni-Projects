<?php
session_start();

// Check if the logged-in user is the admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'hackerssg@gmail.com') {
    die("Access denied. Only admin can access this page.");
}
// Database connection
$host = 'localhost';
$db = 'logs';
$username = 'hackerssg';
$password = 'crlf';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle search filter
$tool_filter = isset($_GET['tool']) ? $_GET['tool'] : '';
$command_filter = isset($_GET['command']) ? $_GET['command'] : '';

// Fetch logs based on the filter
$query = "SELECT * FROM user_logs WHERE 1";
if ($tool_filter) {
    $query .= " AND tool_used LIKE :tool_filter";
}
if ($command_filter) {
    $query .= " AND input_command LIKE :command_filter";
}

$stmt = $conn->prepare($query);

if ($tool_filter) {
    $stmt->bindValue(':tool_filter', "%$tool_filter%");
}
if ($command_filter) {
    $stmt->bindValue(':command_filter', "%$command_filter%");
}

$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics for tool usage
$tool_stats = [];

foreach ($logs as $log) {
    $tool_stats[$log['tool_used']] = isset($tool_stats[$log['tool_used']]) ? $tool_stats[$log['tool_used']] + 1 : 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Analytics - Logs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f7fc;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 1rem;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        button {
            padding: 12px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 6px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* User registration stats section */
        .stats-container {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stats-container h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .stats-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .stat-item {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            width: 200px;
            text-align: center;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<h1>User Analytics - Logs</h1>

<div class="search-container">
    <form method="GET" action="user_analytics.php">
        <input type="text" name="tool" placeholder="Search by Tool" value="<?= htmlspecialchars($tool_filter) ?>">
        <input type="text" name="command" placeholder="Search by Command" value="<?= htmlspecialchars($command_filter) ?>">
        <button type="submit">Search</button>
    </form>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Tool Used</th>
        <th>Input Command</th>
        <th>Timestamp</th>
    </tr>
    <?php foreach ($logs as $log): ?>
    <tr>
        <td><?= htmlspecialchars($log['id']) ?></td>
        <td><?= htmlspecialchars($log['email']) ?></td>
        <td><?= htmlspecialchars($log['tool_used']) ?></td>
        <td><?= htmlspecialchars($log['input_command']) ?></td>
        <td><?= htmlspecialchars($log['timestamp']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Tool Usage Stats -->
<div class="stats-container">
    <h3>Tool Usage Stats</h3>
    <div class="stats-list">
        <?php foreach ($tool_stats as $tool => $count): ?>
        <div class="stat-item">
            <strong><?= htmlspecialchars($tool) ?></strong>
            <p><?= $count ?> Usage(s)</p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
