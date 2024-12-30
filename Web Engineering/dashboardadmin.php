<?php
session_start();

// Check if the logged-in user is the admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'hackerssg@gmail.com') {
    die("Access denied. Only admin can access this page.");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    


</head>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebar-wrapper" aria-controls="sidebar-wrapper">
                ☰
            </button>
            <span class="navbar-brand ms-2" id="admin-dashboard-link">Admin Dashboard</span>
        </div>
    </nav>


    <!-- Sidebar (Offcanvas for mobile screens) -->
    <div class="offcanvas offcanvas-start bg-dark" id="sidebar-wrapper" tabindex="-1" aria-labelledby="sidebar-label">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title text-white" id="sidebar-label">Admin Dashboard</h3>
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
                    <a class="nav-link" href="#" id="users-link-sidebar" data-bs-dismiss="offcanvas">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="settings-link-sidebar" data-bs-dismiss="offcanvas">Settings</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Home Content -->
    <div id="home-content" class="content-section active" style="padding: 10px; overflow-x: hidden;">
        <div class="row">
            <!-- Admin Picture and Details -->
            <div class="col-lg-4 col-md-12 text-center">
                <img src="/uploads/profile-photo.jpeg" alt="Admin Picture" class="rounded-circle mb-3 img-fluid w-50">

                <h3>Muhammad Usman</h3>
                <p><strong>Email:</strong> usman@securetackles.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Location:</strong> New York, USA</p>
                <p><strong>Experience:</strong> 8+ years in IT and Web Security</p>
                <p><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/in/johndoe"
                        target="_blank">linkedin.com/in/johndoe</a></p>
            </div>
            <!-- Admin Skills -->
            <div class="col-lg-8 col-md-12">
                <!-- Admin Bio -->
                <h4>About Me</h4>
                <p>
                    Passionate about securing the web and enhancing IT infrastructure, I specialize in penetration
                    testing,
                    web application security, and database management. My expertise includes identifying
                    vulnerabilities,
                    designing robust security measures, and providing consulting services for secure system
                    implementation.
                </p>
                <!-- Admin Skills -->
                <h4 class="mt-4">Skills</h4>
                <div class="mb-3">
                    <label class="form-label">Web Security</label>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90"
                            aria-valuemin="0" aria-valuemax="100">90%</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Database Management</label>
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%;" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100">85%</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Network Administration</label>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">75%</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penetration Testing</label>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 95%;" aria-valuenow="95"
                            aria-valuemin="0" aria-valuemax="100">95%</div>
                    </div>
                </div>
                <!-- Admin Certifications -->
                <h4 class="mt-4">Certifications</h4>
                <ul>
                    <li>Certified Ethical Hacker (CEH)</li>
                    <li>Offensive Security Certified Professional (OSCP)</li>
                    <li>CompTIA Security+</li>
                    <li>Certified Information Systems Security Professional (CISSP)</li>
                </ul>
                <!-- Admin Interests -->
                <h4 class="mt-4">Interests</h4>
                <p>
                    In addition to cybersecurity, I enjoy mentoring aspiring security professionals, exploring new
                    technologies, and participating in bug bounty programs. Outside of work, I’m passionate about
                    hiking,
                    photography, and community volunteering.
                </p>
            </div>
        </div>
    </div>


    <!-- Analytics Content -->
    <div id="analytics-content" class="content-section" style="overflow-x: hidden;">
        <h2 class="mb-4 text-center">Analytics Dashboard</h2>

        <!-- User Analytics Graph -->
        <div class="chart-container">
            <h3 class="chart-title">User Signups vs Active Users</h3>
            <canvas id="userAnalyticsChart"></canvas>
        </div>

        <!-- Tool Usage Graph -->
        <div class="chart-container">
            <h3 class="chart-title">Tool Usage Statistics</h3>
            <canvas id="toolUsageChart"></canvas>
        </div>

        <!-- Revenue Analytics -->
        <div class="chart-container">
            <h3 class="chart-title">Monthly Revenue</h3>
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- System Performance -->
        <div class="row mt-5">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Server Uptime</h5>
                        <p class="card-text"><strong>99.95%</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">API Response Time</h5>
                        <p class="card-text"><strong>120ms</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Error Rate</h5>
                        <p class="card-text"><strong>0.02%</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Demographics -->
        <div class="chart-container mt-5">
            <h3 class="chart-title">User Demographics</h3>
            <canvas id="userDemographicsChart"></canvas>
        </div>

        <!-- Notifications and Alerts -->
        <div class="mt-5">
            <h4>Recent Alerts</h4>
            <ul class="list-group">
                <li class="list-group-item">High login failure rate detected on 01-Dec-2024</li>
                <li class="list-group-item">Scheduled maintenance planned for 05-Dec-2024</li>
                <li class="list-group-item">New security patch applied on 28-Nov-2024</li>
            </ul>
        </div>
    </div>


    <!-- Users Content -->
    <div id="users-content" class="content-section container-fluid" style="overflow-x: hidden;">
        <h2 class="text-center mb-4">Manage Users</h2>

        <!-- Filters and Search Bar -->
        <div class="d-flex justify-content-between mb-3">
            <input type="text" id="user-search" class="form-control w-25" placeholder="Search users..."
                onkeyup="filterUsers()">
            <select id="user-role-filter" class="form-control w-25" onchange="filterUsers()">
                <option value="">Filter by Role</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
            <button class="btn btn-primary" onclick="openAddUserModal()">Add User</button>
        </div>

        <!-- Table for displaying user data -->
        <div class="table-responsive m-3">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Account Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    <!-- Example User List -->
                    <tr id="user-1">
                        <td>1</td>
                        <td>JaneDoe</td>
                        <td>janedoe@example.com</td>
                        <td>Admin</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td id="last-login-1">Loading...</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="viewUserDetails(1)">View Details</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(1)">Delete</button>
                        </td>
                    </tr>
                    <tr id="user-2">
                        <td>2</td>
                        <td>JohnSmith</td>
                        <td>johnsmith@example.com</td>
                        <td>User</td>
                        <td><span class="badge badge-warning">Inactive</span></td>
                        <td id="last-login-2">Loading...</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="viewUserDetails(2)">View Details</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(2)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add User Modal -->
        <div id="add-user-modal" class="modal" tabindex="-1" role="dialog" style="display:none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="close" onclick="closeAddUserModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-user-form">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" required>
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details Section -->
        <div id="user-detail-section" class="user-detail-section p-3 rounded shadow bg-light" style="display: none;">
            <h4 class="text-center mb-4">User Details</h4>
            <p><strong>Username:</strong> <span id="user-detail-username"></span></p>
            <p><strong>Email:</strong> <span id="user-detail-email"></span></p>
            <p><strong>Role:</strong> <span id="user-detail-role"></span></p>
            <p><strong>Account Status:</strong> <span id="user-detail-status"></span></p>
            <p><strong>Last Login:</strong> <span id="user-detail-last-login"></span></p>
            <div class="text-center">
                <button class="btn btn-secondary" onclick="closeUserDetails()">Close</button>
            </div>
        </div>
    </div>



    <!-- setting section -->

    <div id="settings-content" class="content-section" style="overflow-x: hidden;">
        <h2 class="mb-4">Admin Settings</h2>
        <!-- Change Password Form -->
        <div class="card">
            <div class="card-header">
                <h5>Change Password</h5>
            </div>
            <div class="card-body">
                <form id="change-password-form" action="change-password.php" method="POST">
                    <div class="mb-3">
                        <label for="old-password" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="old-password" name="old-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new-password" name="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>

        <!-- Profile Settings -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Profile Settings</h5>
            </div>
            <div class="card-body">
                <form id="profile-settings-form" action="update-profile.php" method="POST">
                    <div class="mb-3">
                        <label for="admin-name" class="form-label">Admin Name</label>
                        <input type="text" class="form-control" id="admin-name" name="admin-name" value="John Doe"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="admin-email" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="admin-email" name="admin-email"
                            value="admin@example.com" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Profile</button>
                </form>
            </div>
        </div>
    </div>








 <!-- Admin Card Dropdown Cart -->
<div class="card text-center shadow" id="admin-card" style="display: none;">
    <div id="close-admin-card" style="cursor: pointer;">&times;</div>
    <div class="card-body">
        <img src="/uploads/profile-photo.jpeg" alt="Admin Picture" class="rounded-circle mb-3">
        <h5 class="card-title">Muhammad Usman</h5>
        <a href="/logout.php" class="btn btn-danger" id="logout-button">Logout</a>
    </div>
</div>


    <!-- Footer Section -->
    <footer class="footer bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-1">© 2024 Cyber Warriors</p>
            <a href="/privacy-policy" class="text-white text-decoration-none">Privacy Policy</a> |
            <a href="/terms" class="text-white text-decoration-none">Terms of Service</a>
        </div>
    </footer>



    <script src="admin.js"></script>
</body>

</html>