<?php
session_start(); // Start the session to access session variables

// Database connection
$servername = "localhost";
$username = "hackerssg";
$password = "crlf";
$dbname = "logs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['input'])) {
        $input = escapeshellarg(trim($_POST['input']));

        // Assuming the logged-in user's email is stored in the session
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email']; // Get the logged-in user's email
        } else {
            // If no session exists, return an error or default email
            $email = "guest@example.com"; // Default email (can be adjusted)
        }

        $tool_used = "waybackurls";
        $input_command = "waybackurls $input"; // Command used

        // Insert log into database
        $stmt = $conn->prepare("INSERT INTO user_logs (email, tool_used, input_command) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $tool_used, $input_command);
        $stmt->execute();
        $stmt->close();

        // Run waybackurls command
        $output_file = tempnam(sys_get_temp_dir(), 'urls_');
        $waybackurls_command = "waybackurls $input > $output_file 2>&1";
        exec($waybackurls_command, $output, $return_var);

        // Capture the output
        if ($return_var === 0) {
            $urls = file_get_contents($output_file);
            $urlCount = substr_count($urls, "\n");
            echo json_encode(['success' => true, 'output' => $urls, 'urlCount' => $urlCount]);
        } else {
            $error_output = implode("\n", $output);
            echo json_encode(['success' => false, 'error' => $error_output]);
        }
        unlink($output_file);
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
    <title>URL Finder</title>
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
            overflow-y: auto;  /* Enables vertical scrolling */
        }
        input[type="text"], input[type="button"] {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="button"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        #copyButton {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        #copyButton:disabled {
            background-color: #ccc;
        }
        #urlCountHeading {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Find URLs</h2>
    <form id="urlForm" method="POST">
        <input type="text" id="input" name="input" placeholder="Enter URL or domain (e.g., https://example.com or example.com)" required>
        <input type="button" id="runCommand" value="Find URLs" onclick="runWaybackurls()" />
    </form>

    <h3 id="urlCountHeading" style="display:none;">URLs Found: 0</h3>

    <div id="output"></div>

    <button id="copyButton" onclick="copyResults()" style="display:none;">Copy Results</button>

    <script>
        function runWaybackurls() {
            const input = document.getElementById('input').value.trim();
            if (!input) {
                alert("Please enter a valid input.");
                return;
            }

            document.getElementById('runCommand').disabled = true;  // Disable button
            document.getElementById('output').textContent = "Running waybackurls... Please wait...";

            fetch('', {
                method: 'POST',
                body: new URLSearchParams({ 'input': input })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('runCommand').disabled = false;  // Enable button after execution
                if (data.success) {
                    document.getElementById('output').textContent = data.output;
                    document.getElementById('urlCountHeading').style.display = 'block';
                    document.getElementById('urlCountHeading').textContent = `URLs Found: ${data.urlCount}`;
                    document.getElementById('copyButton').style.display = 'inline-block';
                } else {
                    document.getElementById('output').textContent = "Error: " + data.error;
                    document.getElementById('urlCountHeading').style.display = 'none';
                    document.getElementById('copyButton').style.display = 'none';
                }
            })
            .catch(error => {
                document.getElementById('runCommand').disabled = false;
                document.getElementById('output').textContent = "An error occurred: " + error.message;
                document.getElementById('urlCountHeading').style.display = 'none';
                document.getElementById('copyButton').style.display = 'none';
            });
        }

        function copyResults() {
            const outputText = document.getElementById('output').textContent;
            navigator.clipboard.writeText(outputText).then(() => {
                alert("Results copied to clipboard!");
            }).catch(err => {
                alert("Failed to copy: " + err.message);
            });
        }
    </script>

</body>
</html>
