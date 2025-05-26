<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "user_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
  header("Location: index.html"); // Redirect to index.html
  exit(); // Always add exit after header()
} else {
  echo "Invalid email or password.";
}

$conn->close();
?>

