<?php
include('db.php');

// Adjusted query to fetch the 'username' from 'users' table without trying to fetch a non-existent 'email' field.
$query = $conn->query("
    SELECT applicants.*, users.username AS name
    FROM applicants
    INNER JOIN users ON applicants.user_id = users.user_id
");

if ($query && $query->num_rows > 0) {
    echo "<ul>";
    while ($row = $query->fetch_assoc()) {
        $name = htmlspecialchars($row['name']);
        // Since there is no email in the 'users' table, it is not included here.
        echo "<li>" . $name . "</li>";
    }
    echo "</ul>";
} else {
    echo "No applicants found or there was an error in the query.";
}
?>
