<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection settings
$host = "localhost";
$user = "root";         // Default for XAMPP
$password = "";         // Default password is empty
$database = "user_db";  // Your MySQL database name

// Create database connection
$conn = new mysqli($host, $user, $password, $database);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate fields (optional, but recommended)
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    die("All fields are required.");
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

if ($stmt->execute()) {
    // Redirect to login page after successful signup
    header("Location: last.html");  // Change to your login page filename
    exit();
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
