<?php
// Include the database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is uploaded
    if (isset($_FILES['resume'])) {
        $file_name = $_FILES['resume']['name'];
        $file_tmp = $_FILES['resume']['tmp_name'];
        $file_type = $_FILES['resume']['type'];

        // Check if file is a valid PDF
        $allowed_types = array('application/pdf');
        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file to a directory
            $upload_dir = "uploads/";
            move_uploaded_file($file_tmp, $upload_dir . $file_name);

            // Update the resume file name in the database
            $user_id = $_SESSION['user_id'];
            $query = $conn->prepare("UPDATE users SET resume = ? WHERE user_id = ?");
            $query->bind_param("si", $file_name, $user_id);
            $query->execute();

            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            // Invalid file type
            echo "Error: Please upload a PDF file.";
        }
    }
}
?>
