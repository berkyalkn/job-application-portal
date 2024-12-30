<?php

session_start();
include('../../db/config.php');

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$hashedPassword = password_hash('admin', PASSWORD_DEFAULT); 

$sql = "UPDATE users SET password = ? WHERE username = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $hashedPassword);
$stmt->execute();



if ($role === 'admin') {
    $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
} else {
    $sql = "SELECT * FROM users WHERE username = ? AND role = ?";
}

$stmt = $conn->prepare($sql);
if ($role === 'admin') {
    $stmt->bind_param('s', $username);
} else {
    $stmt->bind_param('ss', $username, $role);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(['error' => 'Username not found or incorrect role.']);
    exit;
}

$user = $result->fetch_assoc();


if (!password_verify($password, $user['password'])) {
    echo json_encode(['error' => 'Incorrect password.']);
    exit;
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role']; 

echo json_encode(['success' => 'Login successful', 'role' => $user['role']]);


$stmt->close();
$conn->close();
?>

