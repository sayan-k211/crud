<?php
include "connection.php";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Prepare the SQL delete statement
    $delete = $connection->prepare("DELETE FROM scp WHERE id = ?");
    
    if (!$delete) {
        echo "<div class='alert alert-danger p-3 m-2'>Error preparing delete statement: {$connection->error}</div>";
        exit;
    }
    
    // Bind the ID parameter
    $delete->bind_param("i", $id);
    
    // Execute the statement and check for success
    if ($delete->execute()) {
        // Redirect back to index.php after successful deletion
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger p-3 m-2'>Error: {$delete->error}</div>";
    }

    // Close the statement
    $delete->close();
} else {
    echo "<div class='alert alert-danger p-3 m-2'>No record ID provided for deletion.</div>";
}

// Close the connection
$connection->close();
?>
