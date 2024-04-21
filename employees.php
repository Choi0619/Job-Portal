<?php
include('db.php');

$query = $conn->query("SELECT * FROM employees");
echo "<ul>";
while ($row = $query->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['position']) . "</li>";
}
echo "</ul>";
?>
