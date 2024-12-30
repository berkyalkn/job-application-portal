<?php

session_start();
include('../../db/config.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];


$hashed_password = password_hash($password, PASSWORD_BCRYPT);


$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $username, $email, $hashed_password, $role);


if ($stmt->execute()) {
    echo json_encode(['success' => 'Registration successful! You can now log in.']);
} else {
    echo json_encode(['error' => 'An error occurred. Please try again.']);
}

$stmt->close();
$conn->close();
?>