<?php

session_start();
include '../../db/config.php';

$username = $_SESSION['username'];
echo json_encode(['username' => $username]);

$conn->close();
?>
