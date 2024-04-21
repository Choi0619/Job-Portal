<?php
include('db.php');  // Include database connection

$error_message = ""; // Initialize error message variable

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $email_query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $email_query->bind_param("s", $email);
        $email_query->execute();
        $email_result = $email_query->get_result();

        if ($email_result->num_rows > 0) {
            $error_message = "Email already in use!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $query = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $query->bind_param("sss", $username, $email, $hashed_password);
            $query->execute();

            if ($query->affected_rows > 0) {
                header("Location: index.php"); // Redirect to index page
                exit();
            } else {
                $error_message = "Registration failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="login-container">
        <form class="form-login" action="" method="POST">
            <ul class="login-nav">
                <li class="login-nav__item">
                    <a href="login.php">Log In</a>
                </li>
                <li class="login-nav__item active">
                    <a href="#">Sign Up</a>
                </li>
            </ul>
            <label for="username" class="login__label">Username:</label>
            <input type="text" id="username" class="login__input" name="username" required>

            <label for="email" class="login__label">Email:</label>
            <input type="email" id="email" class="login__input" name="email" required>

            <label for="password" class="login__label">Password:</label>
            <input type="password" id="password" class="login__input" name="password" required>

            <label for="confirm_password" class="login__label">Confirm Password:</label>
            <input type="password" id="confirm_password" class="login__input" name="confirm_password" required>

            <button type="submit" class="login__submit" name="register">Sign Up</button>
            
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <p class="login__forgot">Already a member? <a href="login.php">Log in here</a></p>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
