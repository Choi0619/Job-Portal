<?php
// Include header
include('header.php');

// Check if user is admin
if (!isset($_SESSION['admin'])) {
    // Redirect to login page if user is not admin
    header("Location: login.php");
    exit();
}
?>

<main>
    <h2>Manage</h2>
    <div class="card-container">
        <!-- Card 1: View/Delete Users and Company Users -->
        <div class="card">
            <h3>View/Delete Users</h3>
            <p>Manage regular users' accounts.</p>
            <a href="manage_user.php">Go to User Management</a>
        </div>

        <!-- Card 2: Add/Drop Categories -->
        <div class="card">
            <h3>Add/Drop Categories</h3>
            <p>Add or remove job categories.</p>
            <a href="manage_category.php">Go to Category Management</a>
        </div>

        <!-- Card 3: Add/Drop Skills -->
        <div class="card">
            <h3>Add/Drop Skills</h3>
            <p>Add or remove skills.</p>
            <a href="manage_skill.php">Go to Skill Management</a>
        </div>

        <!-- Card 4: View Contact Messages -->
        <div class="card">
            <h3>View Contact Messages</h3>
            <p>View messages submitted through contact form.</p>
            <a href="manage_message.php">Go to Contact Messages</a>
        </div>
    </div>
</main>

<?php
// Include footer
include('footer.php');
?>
