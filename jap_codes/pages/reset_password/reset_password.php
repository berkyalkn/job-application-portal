<?php

session_start();
include('../../db/config.php');

$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 0) {
    echo json_encode(['error' => 'Email not found.']);
    exit;
}


echo json_encode(['success' => 'Password reset link sent to your email.']);

$stmt->close();
$conn->close();
?>
