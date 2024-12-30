<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: /first_login.html"); // Redirect to login page if not logged in
    exit();
}



// Database connection
$servername = "localhost";
$username = "hackerssg";  // Your database username
$password = "crlf";       // Your database password
$dbname = "user";         // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's profile picture from the database using email
$email = $_SESSION['email']; // Use email stored in session
$sql = "SELECT profile_picture FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($profile_picture);
$stmt->fetch();
$stmt->close();

// If no profile picture is set in the database, use a default one
if (empty($profile_picture)) {
    $profile_picture = 'uploads/default_profile_pic.jpg'; // Default image if not set
}

// Store the profile picture in the session
$_SESSION['profile_picture'] = $profile_picture;

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="user.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebar-wrapper" aria-controls="sidebar-wrapper">
                ☰
            </button>
            <span class="navbar-brand ms-2" id="user-dashboard-link">User Dashboard</span>
        </div>
    </nav>

    <!-- Sidebar (Offcanvas for Mobile Screens) -->
    <div class="offcanvas offcanvas-start bg-dark w-25%" id="sidebar-wrapper" tabindex="-1"
        aria-labelledby="sidebar-label">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title text-white" id="sidebar-label">User Dashboard</h3>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="home-link-sidebar" data-bs-dismiss="offcanvas">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="analytics-link-sidebar" data-bs-dismiss="offcanvas">Analytics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="users-link-sidebar" data-bs-dismiss="offcanvas">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="tools-link-sidebar" data-bs-dismiss="offcanvas">Tools</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="settings-link-sidebar" data-bs-dismiss="offcanvas">Settings</a>
                </li>
            </ul>
        </div>
    </div>

<!-- Main Content Area -->
<div id="page-content-wrapper" class="container mt-4" style="overflow-x: hidden;">

     <!-- Feedback Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

    <!-- Home Content -->
    <div id="home-content" class="content-section active">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 text-primary">
                Welcome Back, <span class="text-dark"><?= htmlspecialchars($_SESSION['username']) ?>!</span>
            </h2>
            <p class="text-muted lead">
                Here’s a quick overview of your profile and account settings.
            </p>
        </div>

         <!-- User Information Section -->
    <div class="container mt-5">
        <div class="row g-4">

<!-- Profile Section -->
<div class="col-lg-4">
    <div class="card shadow border-0 text-center">
        <div class="card-body">
            <!-- Profile Picture -->
            <img src="<?= htmlspecialchars($_SESSION['profile_picture']) ?>" alt="User Profile-photo" class="rounded-circle mb-3 profile-img" data-bs-toggle="modal" data-bs-target="#profileModal">

            <h5 class="fw-bold"><?= htmlspecialchars($_SESSION['username']) ?></h5> <!-- Display email instead of username -->
            <p class="text-muted mb-2"><?= htmlspecialchars($_SESSION['email']) ?></p>
            <a href="update_picture.php" class="btn btn-outline-primary btn-sm mt-3">Edit Photo</a>
        </div>
    </div>
</div>


            <!-- User Information -->
            <div class="col-lg-8">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($_SESSION['username']) ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

      



            <!-- Tools and Analytics Section -->
            <div class="row mt-5 g-4">
                <!-- Tools -->
                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-info text-white text-center">
                            <h5 class="mb-0">Explore Tools</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted">Access a variety of tools designed to enhance your workflow.</p>
                            <a href="#tools-content" class="btn btn-info btn-lg mt-3 w-100">Go to Tools</a>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-secondary text-white text-center">
                            <h5 class="mb-0" style="cursor: pointer;" onclick="scrollToAnalytics()">View Analytics</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted">Check detailed statistics about your activity and performance.</p>
                            <a href="#analytics-content" class="btn btn-secondary btn-lg mt-3 w-100"
                                onclick="scrollToAnalytics(event)">View Analytics</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Analytics Content -->
    <div id="analytics-content" class="content-section container py-5">
        <!-- Header -->
        <h2 class="mb-5 text-center text-primary fw-bold">Analytics Dashboard</h2>

        <!-- Monthly Line Graph Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Tool Usage by Users (Monthly)</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative;">
                            <canvas id="userAnalyticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Circle Graphs Section -->
        <div class="row justify-content-center g-4">
            <!-- Tool Usage Doughnut Graph -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-info text-white text-center">
                        <h3 class="mb-0">Tool Usage Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="toolUsageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Time Spent Pie Graph -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-secondary text-white text-center">
                        <h3 class="mb-0">Time Spent on Tools</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="timeSpentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap 5 and Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




<!-- User History Content -->
<div id="users-content" class="content-section container-fluid mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">User History</h2>
        <p class="text-muted lead">Track your activities and view detailed insights about your usage.</p>
    </div>

    <!-- Table for displaying user history -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" style="width: 5%;">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tool Used</th>
                    <th scope="col">Command</th>
                    <th scope="col">Date</th>
                    <th scope="col" style="width: 20%;">Actions</th>
                </tr>
            </thead>
            <tbody id="user-history-table-body">
                <!-- Rows will be dynamically populated via JavaScript -->
            </tbody>
        </table>
    </div>

   <div class="text-center mt-4">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" 
                type="button" 
                id="downloadLogsDropdown" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            Download Logs
        </button>
        <ul class="dropdown-menu" aria-labelledby="downloadLogsDropdown">
    
            <li><a class="dropdown-item" href="#" onclick="downloadLogs('json')">JSON</a></li>
            <li><a class="dropdown-item" href="#" onclick="downloadLogs('txt')">TXT</a></li>
        </ul>
    </div>
</div>

</div>

<script>
    // Fetch logs for the currently logged-in user
    fetch('fetch_logs.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('user-history-table-body');
            if (data.length > 0) {
                data.forEach((log, index) => {
                    const timestamp = new Date(log.timestamp).toLocaleString(); // Format the timestamp
                    const command = log.input_command
                        ? log.input_command.substring(0, 50) + '...'
                        : 'No command available'; // Truncate if too long

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${log.email}</td>
                        <td>${log.tool_used}</td>
                        <td>${command}</td>
                        <td>${timestamp}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteLog(${log.id})">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No activity found.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching logs:', error);
        });

    function downloadLogs(format) {
    const url = `download_logs.php?format=${encodeURIComponent(format)}`;
    window.open(url, '_blank'); // Open the download URL in a new tab
}

    // Function to handle log deletion
    function deleteLog(logId) {
        if (confirm('Are you sure you want to delete this log?')) {
            fetch(`delete_log.php?id=${logId}`, {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Log deleted successfully!');
                        location.reload();
                    } else {
                        alert('Failed to delete log.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting log:', error);
                });
        }
    }
</script>




    <!-- Tool Cards Section -->
    <div id="tools-cards-content" class="content-section">
        <h2 class="text-center mb-4">Our Tools</h2>
        <div class="row g-4">
            <!-- Tool 1 -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card tool-card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Tool 1">
                    <div class="card-body">
                        <h5 class="card-title">Subdomain Enumeration</h5>
                        <p class="card-text">This tool performs subdomain enumeration operations on provided domain.</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary" onclick="window.location.href='/enumeration.php'">Use Tool</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tool 2 -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card tool-card">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Tool 2">
                    <div class="card-body">
                        <h5 class="card-title">Crawling Tool</h5>
                        <p class="card-text">This tool performs crawling operations on websites.</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary" onclick="window.location.href='/crawling.php'">Use Tool</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tool Content Section -->
    <div id="tool-content-container" class="content-section" style="display:none;">
        <div class="mb-3">
            <button class="btn btn-secondary" onclick="goBackToTools()">Go Back</button>
        </div>
        <div id="tool-content" class="tool-content"></div>
    </div>


  <!-- Settings Content -->
<div id="settings-content" class="content-section">
    <div class="m-5 mt-0">
        <h2>User Settings</h2>
        <p>Change your account settings, including updating your email and password.</p>
    </div>

    
    <!-- Email Update Section -->
    <div class="card mb-4 m-5">
        <div class="card-header">
            <h5>Update Email</h5>
        </div>
        <div class="card-body">
            <form id="update-email-form" method="POST" action="update_setting.php">
                <div class="form-group">
                    <label for="current-email">Current Email</label>
                    <input type="email" class="form-control" id="current-email" value="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
                <div class="form-group mt-3">
                    <label for="new-email">New Email</label>
                    <input type="email" class="form-control" id="new-email" name="new-email" placeholder="Enter your new email" required>
                </div>
            
                <button type="submit" class="btn btn-primary mt-3" id="update-email-btn">Update Email</button>
            </form>
        </div>
    </div>

   
</div>


</div>]


<!-- User Card Dropdown Cart -->
<div class="card text-center shadow" id="user-card" style="display: none;">
    <div id="close-user-card" style="cursor: pointer;">&times;</div>
    <div class="card-body">
        <!-- Profile Picture -->
        <img src="<?= htmlspecialchars($_SESSION['profile_picture']) ?>" alt="profile Picture" class="rounded-circle mb-3">

        <!-- Display Username -->
        <h5 class="card-title"><?= htmlspecialchars($_SESSION['username']) ?></h5>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger" id="logout-button">Logout</a>
    </div>
</div>







    <script src="user.js"></script>
</body>

<!-- Footer Section -->
<footer class="footer bg-dark text-white text-center py-3 mt-auto">
    <div class="container">
        <p class="mb-1">© 2024 Cyber Warriors</p>
        <a href="/privacy-policy" class="text-white text-decoration-none">Privacy Policy</a> |
        <a href="/terms" class="text-white text-decoration-none">Terms of Service</a>
    </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>




</html>