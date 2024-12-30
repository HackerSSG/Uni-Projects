<?php
session_start(); // Start session to access session variables

// Database connection
$servername = "localhost";
$username = "hackerssg";
$password = "crlf";
$dbname = "logs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['url'])) {
        $url = escapeshellarg(trim($_POST['url']));

        // Log received URL for debugging
        file_put_contents('debug.log', "Received URL: " . $url . "\n", FILE_APPEND);

        // Assuming the logged-in user's email is stored in the session
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : "guest@example.com";

        $tool_used = "xss_vibes";
        $output_file = tempnam(sys_get_temp_dir(), 'xss_output_');

        // Set the path to the directory where main.py is located
        $script_dir = '/var/www/html/xss_vibes'; // Adjust this path as needed
        $command = "cd $script_dir && python3 main.py -u $url -o $output_file 2>&1";

        // Log the command in the database
        $stmt = $conn->prepare("INSERT INTO user_logs (email, tool_used, input_command) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $tool_used, $command);
        $stmt->execute();
        $stmt->close();

        // Log the command for debugging
        file_put_contents('debug.log', "Executing command: " . $command . "\n", FILE_APPEND);

        // Execute the command
        exec($command, $output, $return_var);

        // Log command output for debugging
        file_put_contents('debug.log', "Command Output: " . implode("\n", $output) . "\n", FILE_APPEND);

        if ($return_var === 0 && file_exists($output_file)) {
            $results = file_get_contents($output_file);
            unlink($output_file); // Clean up temporary file

            echo json_encode(['success' => true, 'output' => $results]);
        } else {
            $error_output = implode("\n", $output);
            echo json_encode(['success' => false, 'error' => $error_output]);
        }
        exit;
    }
}

// Close database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        #output {
            width: 100%;
            height: 300px;
            border: 1px solid #ccc;
            margin-top: 20px;
            padding: 10px;
            white-space: pre-wrap;
            background-color: #f9f9f9;
            overflow-y: auto;
        }
        input[type="text"], input[type="button"] {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <h2>XSS Scanner</h2>
    <form id="xssForm">
        <input type="text" id="url" name="url" placeholder="Enter URL (e.g., http://example.com/page?param=1)" required>
        <input type="button" id="runCommand" value="Scan for XSS" onclick="runXSSScanner()" />
    </form>

    <div id="output"></div>

    <script>
        function runXSSScanner() {
            const url = document.getElementById('url').value.trim();
            if (!url) {
                alert("Please enter a valid URL.");
                return;
            }

            document.getElementById('runCommand').disabled = true;  // Disable button
            document.getElementById('output').textContent = "Running XSS scanner... Please wait...";

            fetch('', {
                method: 'POST',
                body: new URLSearchParams({ 'url': url })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('runCommand').disabled = false;  // Enable button after execution
                if (data.success) {
                    document.getElementById('output').textContent = data.output;
                } else {
                    document.getElementById('output').textContent = "Error: " + data.error;
                }
            })
            .catch(error => {
                document.getElementById('runCommand').disabled = false;
                document.getElementById('output').textContent = "An error occurred: " + error.message;
            });
        }
    </script>
</body>
</html>
