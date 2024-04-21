<?php
// Include database connection
include('db.php');

// Initialize error message variable
$error_message = "";

if (isset($_POST['login'])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the hashed password and user ID from the database
    $query = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = $username;
            $_SESSION['username'] = $username; // Set username in session
            $_SESSION['user_id'] = $user['user_id']; // Set user ID in session
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="login-container">
        <form class="form-login" action="" method="POST">
            <ul class="login-nav">
                <li class="login-nav__item active">
                    <a href="#">Log In</a>
                </li>
                <li class="login-nav__item">
                    <a href="signup.php">Sign Up</a>
                </li>
            </ul>
            <label for="username" class="login__label">Username:</label>
            <input type="text" id="username" class="login__input" name="username" required>
            <label for="password" class="login__label">Password:</label>
            <input type="password" id="password" class="login__input" name="password" required>
            <button type="submit" class="login__submit" name="login">Login</button>
            <?php if (!empty($error_message)): ?>
                <p class="login__forgot" style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <p class="login__forgot">Not a member? <a href="signup.php">Sign up now</a></p>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
