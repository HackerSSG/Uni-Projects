<?php
session_start();

// Check if the logged-in user is the admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'hackerssg@gmail.com') {
    die("Access denied. Only admin can access this page.");
}

// Database connection
$host = 'localhost';
$db = 'user';
$username = 'hackerssg';
$password = 'crlf';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: user.php");
    exit;
}

// Handle update request
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $id]);
    header("Location: user.php");
    exit;
}

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate stats
$totalUsers = count($users);
$usersWithPictures = count(array_filter($users, fn($user) => !empty($user['profile_picture'])));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        button {
            padding: 8px 12px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        form {
            display: inline-block;
            margin-right: 10px;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            gap: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stats-box {
            text-align: center;
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            width: 30%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-box h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .stats-box p {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .stats-box .icon {
            font-size: 40px;
            margin-bottom: 10px;
            color: #007bff;
        }

    </style>
</head>
<body>

<h1>Admin Panel - Registered Users</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Profile Picture</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture">
            <?php else: ?>
                No Picture
            <?php endif; ?>
        </td>
        <td>
            <form method="POST" action="user.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
            <a href="user.php?delete=<?= htmlspecialchars($user['id']) ?>">
                <button type="button">Delete</button>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Stats Section -->
<div class="stats-container">
    <div class="stats-box">
        <div class="icon">👥</div>
        <h3>Total Users</h3>
        <p><?= $totalUsers ?></p>
    </div>

    <div class="stats-box">
        <div class="icon">📸</div>
        <h3>Users with Profile Pictures</h3>
        <p><?= $usersWithPictures ?></p>
    </div>

    <div class="stats-box">
        <div class="icon">🛠️</div>
        <h3>Admin Tools</h3>
        <p>Manage Users</p>
    </div>
</div>

</body>
</html>
