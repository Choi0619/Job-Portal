<?php
include('db.php');  // Include database connection

$error_message = ""; // Initialize error message variable

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password meets strength requirements
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } elseif ($password !== $confirm_password) {
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
            // Check if username already exists
            $username_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $username_query->bind_param("s", $username);
            $username_query->execute();
            $username_result = $username_query->get_result();

            if ($username_result->num_rows > 0) {
                $error_message = "Username already in use!";
            } else {
                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database
                $query = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $query->bind_param("sss", $username, $email, $hashed_password);
                $query->execute();

                if ($query->affected_rows > 0) {
                    // Redirect to login page after successful registration
                    echo '<script>alert("You have successfully registered for an account!");';
                    echo 'setTimeout(function(){ window.location.href = "login.php"; }, 1000);</script>';
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Registration failed!";
                }
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
    <style>
        .password-rules {
            font-size: 12px;
            color: #666;
            display: block;
            margin-bottom: 8px;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordRules = document.querySelector('.password-rules');
            const errorMessage = document.querySelector('.error-message');

            // Hide password rules description when password input is clicked
            passwordInput.addEventListener('click', function() {
                passwordRules.style.display = 'none';
            });

            // Hide password rules description when the user starts typing
            passwordInput.addEventListener('input', function() {
                passwordRules.style.display = 'none';
            });

            // Check password requirements when focus leaves password input
            passwordInput.addEventListener('blur', function() {
                const password = passwordInput.value;

                if (!isValidPassword(password)) {
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });

            // Function to validate password requirements
            function isValidPassword(password) {
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                return regex.test(password);
            }
        });
    </script>

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
            <div class="password-rules">Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</div>

            <label for="confirm_password" class="login__label">Confirm Password:</label>
            <input type="password" id="confirm_password" class="login__input" name="confirm_password" required>
            <div class="error-message" style="display: none;">Password does not meet the requirements.</div>

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
