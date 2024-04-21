<?php
include('header.php'); // Include the header
include('db.php'); // Include the database connection

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Retrieve user's information from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = $conn->prepare("SELECT username, email FROM users WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
        echo "<h2>Welcome, $username!</h2>"; // Display the username
        echo "<p>Email: $email</p>"; // Display the email
    } else {
        echo "<p>Error: User information not found in the database.</p>"; // Error message if user information is not found
    }
} else {
    echo "<p>Error: User ID not set.</p>"; // Error message if user ID is not set
}

include('footer.php'); // Include the footer
?>
