<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery_db";

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Database connection failed.'); history.back();</script>");
}

// Get POST data
$email = trim($_POST['email']);
$input_password = $_POST['password'];

// Look up user
$sql = "SELECT id, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $email, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($input_password, $hashed_password)) {
        echo "<script>alert('Login successful!'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Incorrect password.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Email not found.'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
