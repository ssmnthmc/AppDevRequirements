<?php
$host = "localhost";
$user = "root";
$pass = "your_new_password";
$dbname = "student_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>