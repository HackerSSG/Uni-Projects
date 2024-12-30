




// analytics js
// Chart.js: Tool Usage by Users Across Months (Line Chart)
const userAnalyticsCtx = document.getElementById('userAnalyticsChart').getContext('2d');
const userAnalyticsChart = new Chart(userAnalyticsCtx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Months
        datasets: [
            {
                label: 'XSS Tool Usage',
                data: [30, 40, 35, 55, 45, 60], // Fluctuating data
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.3)',
                fill: true,
                lineTension: 0.4, // Smooth out the line curves
                borderWidth: 2
            },
            {
                label: 'Crawling Tool Usage',
                data: [20, 30, 25, 50, 45, 70], // Fluctuating data
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.3)',
                fill: true,
                lineTension: 0.4,
                borderWidth: 2
            },
            {
                label: 'Scanning Tool Usage',
                data: [40, 45, 50, 70, 60, 65], // Fluctuating data
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.3)',
                fill: true,
                lineTension: 0.4,
                borderWidth: 2
            },
            {
                label: 'Recon Tool Usage',
                data: [10, 20, 25, 40, 30, 60], // Fluctuating data
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.3)',
                fill: true,
                lineTension: 0.4,
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleFont: { size: 14 },
                bodyFont: { size: 12 }
            }
        },
        scales: {
            x: {
                grid: {
                    display: true,
                    color: '#e1e1e1'
                },
                ticks: {
                    font: { size: 12 }
                }
            },
            y: {
                grid: {
                    display: true,
                    color: '#e1e1e1'
                },
                ticks: {
                    font: { size: 12 },
                    stepSize: 10
                }
            }
        }
    }
});

// Chart.js: Tool Usage Chart (Doughnut Chart)
const toolUsageCtx = document.getElementById('toolUsageChart').getContext('2d');
const toolUsageChart = new Chart(toolUsageCtx, {
    type: 'doughnut',
    data: {
        labels: ['XSS Tool', 'Crawling Tool', 'Scanning Tool', 'Recon Tool'],
        datasets: [{
            data: [10, 20, 30, 40], // Placeholder data
            backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // This ensures the chart scales with the container
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

// Chart.js: User Time Spent on Tools Chart (Pie Chart)
const timeSpentCtx = document.getElementById('timeSpentChart').getContext('2d');
const timeSpentChart = new Chart(timeSpentCtx, {
    type: 'pie',
    data: {
        labels: ['XSS Tool', 'Crawling Tool', 'Scanning Tool', 'Recon Tool'],
        datasets: [{
            data: [25, 30, 20, 25], // Example percentages
            backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // This ensures the chart scales with the container
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});






// Function to confirm and delete a row
function confirmDelete(index) {
    const confirmAction = confirm('Are you sure you want to delete this entry?');
    if (confirmAction) {
        deleteRow(index);
    }
}

// Function to delete a row
function deleteRow(index) {
    userHistoryData.splice(index, 1); // Remove the entry
    populateUserHistory(); // Re-populate the table
}

// Initial call to populate the history when the page loads
document.addEventListener('DOMContentLoaded', () => {
    populateUserHistory();
});


// Function to navigate between sections
function navigateTo(event, contentId) {
    event.preventDefault();

    // Hide all content sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected content section
    const selectedSection = document.getElementById(contentId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}

// Attach click event listeners for navigation links
document.getElementById('home-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'home-content');
});
document.getElementById('analytics-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'analytics-content');
});
document.getElementById('users-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'users-content');
});
document.getElementById('tools-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'tools-cards-content');
});
document.getElementById('settings-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'settings-content');
});


// tool js
// Function to navigate between sections
function navigateTo(event, contentId) {
    event.preventDefault();

    // Hide all content sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected content section
    const selectedSection = document.getElementById(contentId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}

// Attach click event listeners for navigation links
document.getElementById('home-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'home-content');
});

document.getElementById('users-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'users-content');
});
document.getElementById('tools-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'tools-cards-content');
});
document.getElementById('settings-link-sidebar').addEventListener('click', function (event) {
    navigateTo(event, 'settings-content');
});



//tool section js
// Function to load a specific tool's content
function useTool(toolFile) {
    // Hide the tools card section
    document.getElementById('tools-cards-content').style.display = 'none';

    // Show the tool content container
    document.getElementById('tool-content-container').style.display = 'block';

    // Fetch the PHP content and load it dynamically
    fetch(toolFile)
        .then((response) => {
            if (response.ok) {
                return response.text(); // Fetch the processed HTML content
            } else {
                throw new Error(`Failed to load ${toolFile}: ${response.statusText}`);
            }
        })
        .then((content) => {
            // Inject the content into the container
            document.getElementById('tool-content').innerHTML = content;
        })
        .catch((error) => {
            // Display error message if fetching fails
            document.getElementById('tool-content').innerHTML = `
                <div class="alert alert-danger">
                    Error: ${error.message}
                </div>
            `;
        });
}

// Function to go back to the tools section
function goBackToTools() {
    // Hide the tool content container
    document.getElementById('tool-content-container').style.display = 'none';

    // Show the tools card section
    document.getElementById('tools-cards-content').style.display = 'block';

    // Clear the tool content to reset
    document.getElementById('tool-content').innerHTML = '';
}


 // Toggle email editing
 document.getElementById('edit-email-btn').addEventListener('click', function () {
    document.getElementById('new-email').disabled = false;
    document.getElementById('update-email-btn').style.display = 'inline-block';
    this.style.display = 'none';
});

// Toggle password editing
document.getElementById('edit-password-btn').addEventListener('click', function () {
    document.getElementById('current-password').disabled = false;
    document.getElementById('new-password').disabled = false;
    document.getElementById('confirm-password').disabled = false;
    document.getElementById('update-password-btn').style.display = 'inline-block';
    this.style.display = 'none';
});

// Handle email update
document.getElementById('update-email-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const newEmail = document.getElementById('new-email').value;
    if (newEmail) {
        alert('Email updated successfully to ' + newEmail);
        // Here you would typically make an API call to update the email
        document.getElementById('new-email').disabled = true;
        document.getElementById('update-email-btn').style.display = 'none';
        document.getElementById('edit-email-btn').style.display = 'inline-block';
    }
});

// Handle password update
document.getElementById('update-password-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword && newPassword === confirmPassword) {
        alert('Password updated successfully');
        // Here you would typically make an API call to update the password
        document.getElementById('current-password').disabled = true;
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;
        document.getElementById('update-password-btn').style.display = 'none';
        document.getElementById('edit-password-btn').style.display = 'inline-block';
    } else {
        alert('Passwords do not match!');
    }
});


// card js
// JavaScript to toggle the Admin Card visibility
const userCard = document.getElementById('user-card');
const closeuserCard = document.getElementById('close-user-card');
const userDashboardLink = document.getElementById('user-dashboard-link');

// Function to toggle the card display
function toggleuserCard() {
    // Toggle visibility
    if (userCard.style.display === "none" || userCard.style.display === "") {
        // Show the user card
        userCard.style.display = "block";
    } else {
        // Hide the user card
        userCard.style.display = "none";
    }
}

// Event listener for showing the admin card when clicking on the "Admin Dashboard"
userDashboardLink.addEventListener('click', function (event) {
    event.stopPropagation(); // Prevents propagation to the document
    toggleuserCard(); // Toggle the card visibility
});

// Event listener for closing the admin card when clicking on the close button
closeuserCard.addEventListener('click', function () {
    userCard.style.display = "none"; // Close the card
});

// Close the card when clicking anywhere outside of it or when scrolling
document.addEventListener('click', function (event) {
    if (!userCard.contains(event.target) && event.target !== userDashboardLink) {
        userCard.style.display = "none"; // Close the card if clicked outside
    }
});

// Close the card when the page is scrolled
window.addEventListener('scroll', function () {
    userCard.style.display = "none"; // Close the card on scroll
});

// Prevent the card from closing when clicking inside it
userCard.addEventListener('click', function (event) {
    event.stopPropagation();
});



