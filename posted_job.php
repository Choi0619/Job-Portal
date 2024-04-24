<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if company user is logged in
if (!isset($_SESSION['company_user'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include('db.php');

// Retrieve company ID
$company_id = $_SESSION['company_id'];

// Fetch jobs posted by the company user
$query = $conn->prepare("SELECT * FROM jobs WHERE company_id = ?");
$query->bind_param("i", $company_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posted Jobs</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file -->
</head>
<body>
    <?php include('header.php'); ?> <!-- Include header file -->

    <div class="container">
        <h2>Posted Jobs</h2>
        <?php
        // Check if there are any jobs posted by the company user
        if ($result->num_rows > 0) {
            // Output each job posted by the company user
            while ($row = $result->fetch_assoc()) {
                echo '<div class="job">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
                echo '<p><strong>Salary:</strong> $' . $row['salary'] . '</p>';
                // Buttons for modifying or deleting the job
                echo '<a href="edit_job.php?job_id=' . $row['job_id'] . '" class="edit-job">Edit Job</a>';
                echo '<a href="delete_job.php?job_id=' . $row['job_id'] . '" class="delete-job" onclick="return confirm(\'Are you sure you want to delete this job?\')">Delete Job</a>';
                // Button to view applicants for this job
                echo '<a href="applicants.php?job_id=' . $row['job_id'] . '" class="view-applicants">View Applicants</a>';
                echo '</div>';
            }
        } else {
            // If no jobs are posted by the company user
            echo '<p>No jobs posted yet.</p>';
        }
        ?>
    </div>

    <?php include('footer.php'); ?> <!-- Include footer file -->
</body>
</html>
