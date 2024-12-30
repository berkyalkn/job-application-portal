<?php
session_start();
include '../../db/config.php';

$username = $_SESSION['username'] ?? ''; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($username) && isset($_POST['job_id'])) {
        $job_id = $_POST['job_id'];
        $application_date = date('Y-m-d H:i:s'); 

        $stmt = $conn->prepare("INSERT INTO applications (job_id, username, application_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $job_id, $username, $application_date);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Başvuru başarılı']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Başvuru sırasında hata oluştu']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Geçersiz başvuru verisi']);
    }
} else {
    if ($username) {
        echo json_encode(['success' => true, 'username' => $username]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Kullanıcı oturum açmamış']);
    }
}

?>
