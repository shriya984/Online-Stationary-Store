<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // No password by default
$dbname = "stationery_db";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

   if ($password !== $confirm_password) {
    echo "<script>alert('Error: Passwords do not match.'); window.history.back();</script>";
    exit;
}

    // ✅ Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

  if ($check_stmt->num_rows > 0) {
    echo "<script>alert('Error: Email already exists. Please use a different one.'); window.history.back();</script>";
    exit;
}

    $check_stmt->close();

    // ✅ Proceed to register user
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $email, $hashed_password);

    if ($stmt->execute()) {
    echo "<script>alert('Registration successful! Redirecting to login page...'); window.location.href = 'login.html';</script>";
} else {
    $errorMsg = addslashes($stmt->error); // Escape quotes for JS
    echo "<script>alert('Error: $errorMsg'); window.history.back();</script>";
}


    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
