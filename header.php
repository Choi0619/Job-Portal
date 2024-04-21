<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT For Hire</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php session_start(); ?>
    <header>
        <div class="title-container">
            <h1>IT For Hire</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="service.php">Service</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="search.php">Search Jobs</a></li>
                <?php
                if (isset($_SESSION['user'])) {
                    // Display dropdown menu for logged-in user
                    echo '<li class="dropdown">';
                    echo '<button class="dropbtn">' . $_SESSION['username'] . '</button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="profile.php">My Profile</a>';
                    echo '<a href="logout.php">Logout</a>';
                    echo '</div>';
                    echo '</li>';
                } else {
                    // Display login and sign-up links for non-logged-in user
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Sign Up</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>
