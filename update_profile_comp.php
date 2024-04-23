<?php
session_start(); // Start the session
include('db.php'); // Include the database connection

// Check if user is logged in
if (!isset($_SESSION['company_user'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user's username from session
    $username = $_SESSION['company_user'];

    // Retrieve form data
    $company_name = !empty($_POST['company_name']) ? $_POST['company_name'] : null;
    $industry = !empty($_POST['industry']) ? $_POST['industry'] : null;
    $size = !empty($_POST['size']) ? $_POST['size'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $address = !empty($_POST['address']) ? $_POST['address'] : null;

    // Update company user information
    $query = $conn->prepare("UPDATE companies SET company_name = ?, industry = ?, size = ?, description = ?, address = ? WHERE username = ?");
    $query->bind_param("ssssss", $company_name, $industry, $size, $description, $address, $username);

    if ($query->execute()) {
        echo "<script>alert('Company information updated successfully.'); window.location.href='profile_comp.php';</script>";
        exit();
    } else {
        echo "Error: Failed to update company information in database.";
        exit();
    }
} else {
    echo "Error: Invalid request method.";
    exit();
}
?>
