<?php

session_start();
include '../../db/config.php'; 

$username = $_SESSION['username'] ?? '';
$searchTerm = $_GET['search'] ?? '';  
$filterType = $_GET['type'] ?? '';   

$sql = "SELECT * FROM jobs WHERE title LIKE ? OR employer_name LIKE ? OR location LIKE ?";
$params = ["%$searchTerm%", "%$searchTerm%", "%$searchTerm%"];

if ($filterType) {
    $sql .= " AND job_type = ?";
    $params[] = $filterType;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$result = $stmt->get_result();

header('Content-Type: application/json'); 


if ($result->num_rows > 0) {
    $jobs = $result->fetch_all(MYSQLI_ASSOC);
    header('Content-Type: application/json');  
    echo json_encode($jobs);  
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>

