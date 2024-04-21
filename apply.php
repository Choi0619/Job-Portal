<?php
// Include header
include('header.php');

// Include database connection
include('db.php');

// Function to create tables if they don't exist
function createTablesIfNeeded($conn) {
    // SQL statements to create tables if they don't exist
    $sql = array(
        "CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            gender VARCHAR(50),
            location VARCHAR(255)
        )",
        // Define other tables similarly
    );

    // Execute each SQL statement
    foreach ($sql as $query) {
        if ($conn->query($query) === FALSE) {
            echo "Error creating table: " . $conn->error;
        }
    }
}

// Create necessary tables if they don't exist
createTablesIfNeeded($conn);

// Check if job_id is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        // Get user_id from session
        $user_id = $_SESSION['user_id'];
        // Insert application into applicants table
        $query = $conn->prepare("INSERT INTO applicants (job_id, user_id) VALUES (?, ?)");
        $query->bind_param("ii", $job_id, $user_id);
        if ($query->execute()) {
            echo "<p>Application submitted successfully!</p>";
        } else {
            echo "<p>Failed to submit application.</p>";
        }
    } else {
        // Prompt to log in
        echo '<div class="login-prompt center">';
        echo 'Please log in to apply for a job.';
        echo '</div>';
        echo '<div class="center">';
        echo '<a href="login.php" class="login-button">Log In</a>';
        echo '</div>';
    }
} else {
    echo "<p>No job selected.</p>";
}

// Include footer
include('footer.php');
?>
