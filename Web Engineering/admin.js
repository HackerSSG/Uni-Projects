// Example user data
const users = [
    { id: 1, username: "JaneDoe", email: "janedoe@example.com", role: "Admin", status: "Active", lastLogin: "2023-12-01 10:30 AM" },
    { id: 2, username: "JohnSmith", email: "johnsmith@example.com", role: "User", status: "Inactive", lastLogin: "2023-11-20 08:00 PM" }
];

// Function to update the user table
function updateUserTable() {
    const tbody = document.getElementById('user-table-body');
    tbody.innerHTML = ''; // Clear existing rows
    users.forEach(user => {
        const row = document.createElement('tr');
        row.id = `user-${user.id}`;
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td><span class="badge ${user.status === 'Active' ? 'badge-success' : 'badge-warning'}">${user.status}</span></td>
            <td id="last-login-${user.id}">${user.lastLogin}</td>
            <td>
                <button class="btn btn-info btn-sm" onclick="viewUserDetails(${user.id})">View Details</button>
                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to view user details
function viewUserDetails(userId) {
    const user = users.find(u => u.id === userId);
    if (user) {
        document.getElementById('user-detail-username').textContent = user.username;
        document.getElementById('user-detail-email').textContent = user.email;
        document.getElementById('user-detail-role').textContent = user.role;
        document.getElementById('user-detail-status').textContent = user.status;
        document.getElementById('user-detail-last-login').textContent = user.lastLogin;

        document.getElementById('user-detail-section').style.display = 'block';
    }
}

// Function to close the user details section
function closeUserDetails() {
    document.getElementById('user-detail-section').style.display = 'none';
}

// Function to delete a user
function deleteUser(userId) {
    const index = users.findIndex(u => u.id === userId);
    if (index !== -1) {
        users.splice(index, 1);
        updateUserTable(); // Update table after deletion
    }
}

// Function to add a new user from the modal form
document.getElementById('add-user-form').onsubmit = function(event) {
    event.preventDefault(); // Prevent the default form submission

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;
    const status = document.getElementById('status').value;

    // Create a new user object
    const newUser = {
        id: users.length + 1,
        username: username,
        email: email,
        role: role,
        status: status,
        lastLogin: "Not logged in yet"
    };

    // Add the new user to the users array
    users.push(newUser);

    // Update the table with the new user
    updateUserTable();

    // Close the modal after adding the user
    closeAddUserModal();
};

// Function to open the add user modal
function openAddUserModal() {
    document.getElementById('add-user-modal').style.display = 'block';
}

// Function to close the add user modal
function closeAddUserModal() {
    document.getElementById('add-user-modal').style.display = 'none';
}

// Function to filter users by search input and role
function filterUsers() {
    const searchInput = document.getElementById('user-search').value.toLowerCase();
    const roleFilter = document.getElementById('user-role-filter').value;

    const filteredUsers = users.filter(user => {
        const matchesSearch = user.username.toLowerCase().includes(searchInput) || user.email.toLowerCase().includes(searchInput);
        const matchesRole = roleFilter ? user.role === roleFilter : true;
        return matchesSearch && matchesRole;
    });

    // Update the table with filtered users
    const tbody = document.getElementById('user-table-body');
    tbody.innerHTML = '';
    filteredUsers.forEach(user => {
        const row = document.createElement('tr');
        row.id = `user-${user.id}`;
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td><span class="badge ${user.status === 'Active' ? 'badge-success' : 'badge-warning'}">${user.status}</span></td>
            <td id="last-login-${user.id}">${user.lastLogin}</td>
            <td>
                <button class="btn btn-info btn-sm" onclick="viewUserDetails(${user.id})">View Details</button>
                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Initial call to update the table
updateUserTable();




// Sidebar Navigation
function showContent(contentId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(contentId).classList.add('active');
}

document.getElementById('home-link-sidebar').addEventListener('click', () => showContent('home-content'));
document.getElementById('analytics-link-sidebar').addEventListener('click', () => showContent('analytics-content'));
document.getElementById('users-link-sidebar').addEventListener('click', () => showContent('users-content'));
document.getElementById('settings-link-sidebar').addEventListener('click', () => showContent('settings-content'));



// Initial data for the charts (Replace with real data as needed)
let userSignupsData = [50, 75, 100, 150, 200, 300, 400];
let activeUsersData = [40, 65, 90, 120, 180, 250, 350];
let toolUsageData = [150, 120, 90, 80, 50];
let revenueData = [3000, 4000, 2000, 1000];
let demographicsData = [55, 35, 7, 3]; // Example: Male, Female, Non-binary, Other

// User Signups vs Active Users Chart
const userAnalyticsCtx = document.getElementById('userAnalyticsChart').getContext('2d');
const userAnalyticsChart = new Chart(userAnalyticsCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        datasets: [
            {
                label: 'Signups',
                data: userSignupsData,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                tension: 0.4
            },
            {
                label: 'Active Users',
                data: activeUsersData,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
            x: {
                beginAtZero: true
            }
        }
    }
});

// Tool Usage Statistics Chart
const toolUsageCtx = document.getElementById('toolUsageChart').getContext('2d');
const toolUsageChart = new Chart(toolUsageCtx, {
    type: 'bar',
    data: {
        labels: ['Tool A', 'Tool B', 'Tool C', 'Tool D', 'Tool E'],
        datasets: [
            {
                label: 'Usage Count',
                data: toolUsageData,
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0'],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
            x: {
                beginAtZero: true
            }
        }
    }
});

// Monthly Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'doughnut',
    data: {
        labels: ['Product A', 'Product B', 'Product C', 'Product D'],
        datasets: [
            {
                label: 'Revenue',
                data: revenueData,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
    }
});

// User Demographics Chart (Ensure it works correctly)
const demographicsCtx = document.getElementById('userDemographicsChart').getContext('2d');
const demographicsChart = new Chart(demographicsCtx, {
    type: 'pie',
    data: {
        labels: ['Male', 'Female', 'Non-binary', 'Other'],
        datasets: [
            {
                label: 'Demographics',
                data: demographicsData,
                backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545'],
                borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Add percentage label
                    }
                }
            }
        }
    }
});

// Function to update charts every second
function updateCharts() {
    // Update User Signups and Active Users data with random values (Replace with real data)
    userSignupsData.push(userSignupsData.shift() + Math.floor(Math.random() * 10) + 5); // Random increase
    activeUsersData.push(activeUsersData.shift() + Math.floor(Math.random() * 10) + 5); // Random increase

    // Update Tool Usage data with random values (Replace with real data)
    toolUsageData.push(toolUsageData.shift() + Math.floor(Math.random() * 5) + 3); // Random increase

    // Update Revenue data with random values (Replace with real data)
    revenueData.push(revenueData.shift() + Math.floor(Math.random() * 1000) + 500); // Random increase

    // Update Demographics data with random values (Replace with real data)
    demographicsData[0] = 50 + Math.floor(Math.random() * 10); // Random male percentage increase
    demographicsData[1] = 40 + Math.floor(Math.random() * 10); // Random female percentage increase
    demographicsData[2] = 5 + Math.floor(Math.random() * 3);  // Random non-binary percentage
    demographicsData[3] = 5 + Math.floor(Math.random() * 3);  // Random other percentage

    // Update all charts with new data
    userAnalyticsChart.update();
    toolUsageChart.update();
    revenueChart.update();
    demographicsChart.update();
}

// Update charts every 1 second (5000ms)
setInterval(updateCharts, 5000);


// Form validation for password change
document.getElementById("change-password-form").addEventListener("submit", function (e) {
    e.preventDefault();

    // Get values from the form fields
    const oldPassword = document.getElementById("old-password").value;
    const newPassword = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    // Basic validation
    if (newPassword !== confirmPassword) {
        alert("New password and confirm password do not match.");
        return;
    }

    if (newPassword.length < 6) {
        alert("New password must be at least 6 characters long.");
        return;
    }

    // If validation passes, you can send the form data to the server using AJAX or a regular form submission
    this.submit();
});

// Form validation for profile settings update
document.getElementById("profile-settings-form").addEventListener("submit", function (e) {
    e.preventDefault();

    // Get values from the form fields
    const adminName = document.getElementById("admin-name").value;
    const adminEmail = document.getElementById("admin-email").value;

    // Basic validation
    if (!adminName || !adminEmail) {
        alert("All fields are required.");
        return;
    }

    // If validation passes, you can send the form data to the server using AJAX or a regular form submission
    this.submit();
});



// JavaScript to toggle the Admin Card visibility
const adminCard = document.getElementById('admin-card');
const closeAdminCard = document.getElementById('close-admin-card');
const adminDashboardLink = document.getElementById('admin-dashboard-link');

// Function to toggle the card display
function toggleAdminCard() {
    // Toggle visibility
    if (adminCard.style.display === "none" || adminCard.style.display === "") {
        // Show the admin card
        adminCard.style.display = "block";
    } else {
        // Hide the admin card
        adminCard.style.display = "none";
    }
}

// Event listener for showing the admin card when clicking on the "Admin Dashboard"
adminDashboardLink.addEventListener('click', function (event) {
    event.stopPropagation(); // Prevents propagation to the document
    toggleAdminCard(); // Toggle the card visibility
});

// Event listener for closing the admin card when clicking on the close button
closeAdminCard.addEventListener('click', function () {
    adminCard.style.display = "none"; // Close the card
});

// Close the card when clicking anywhere outside of it or when scrolling
document.addEventListener('click', function (event) {
    if (!adminCard.contains(event.target) && event.target !== adminDashboardLink) {
        adminCard.style.display = "none"; // Close the card if clicked outside
    }
});

// Close the card when the page is scrolled
window.addEventListener('scroll', function () {
    adminCard.style.display = "none"; // Close the card on scroll
});

// Prevent the card from closing when clicking inside it
adminCard.addEventListener('click', function (event) {
    event.stopPropagation();
});