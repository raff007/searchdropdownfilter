<?php
// Replace these values with your actual database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "gamanagement";

try {
    // Create a PDO instance
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
