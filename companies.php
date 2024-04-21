<?php
include('db.php');

$query = $conn->query("SELECT * FROM companies");
echo "<ul>";
while ($row = $query->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['location']) . "</li>";
}
echo "</ul>";
?>
