<?php

session_start();
include '../../db/config.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$username = $_SESSION['username'];
echo json_encode(['username' => $username]);

$conn->close();
?>
