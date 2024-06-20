<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include credentials
include "credentials.php";

// Create a new database connection
$connection = new mysqli('localhost', $user, $pw, $db);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
