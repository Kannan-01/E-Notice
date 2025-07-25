<?php
$conn = mysqli_connect("localhost", "root", "");
// Create databse
$database = "CREATE DATABASE IF NOT EXISTS enotice";
if (!mysqli_query($conn, $database)) {
    echo "Error creating database: " . mysqli_error($conn);
}
// Select database
mysqli_select_db($conn, "enotice");
?>
