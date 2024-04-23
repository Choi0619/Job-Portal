<?php
// Include the database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // Update user profile in the database
    $user_id = $_SESSION['user_id'];
    $query = $conn->prepare("UPDATE users SET f_name = ?, l_name = ?, date_of_birth = ?, phone = ?, gender = ?, address = ? WHERE user_id = ?");
    $query->bind_param("ssssssi", $f_name, $l_name, $date_of_birth, $phone, $gender, $address, $user_id);
    $query->execute();

    // Redirect to profile page
    header("Location: profile.php");
    exit();
}
?>
