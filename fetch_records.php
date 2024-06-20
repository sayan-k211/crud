<?php
include "connection.php";

// Prepare the SQL statement to select all records
$AllRecords = $connection->prepare("SELECT * FROM scp");
if ($AllRecords === false) {
    die("Prepare failed: " . $connection->error);
}

// Execute the statement
$AllRecords->execute();
$result = $AllRecords->get_result();
if ($result === false) {
    die("Get result failed: " . $connection->error);
}

// Fetch all records as an associative array
$records = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement
$AllRecords->close();
?>
