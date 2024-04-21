<?php
include('db.php');
$action = $_GET['action'] ?? 'view';  // Default to view if no action specified

switch ($action) {
    case 'add':
        // Implement add functionality
        break;
    case 'edit':
        // Implement edit functionality
        break;
    case 'delete':
        // Implement delete functionality
        break;
    default:
        echo "Invalid action.";
}
?>
