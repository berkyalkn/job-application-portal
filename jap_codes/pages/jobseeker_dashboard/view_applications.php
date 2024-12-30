<?php

session_start();
include '../../db/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php');
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT j.job_id, j.title, j.employer_name, j.location, j.job_type, j.salary_range, j.application_deadline
        FROM jobs j
        JOIN applications a ON j.job_id = a.job_id
        WHERE a.username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$applications = [];
while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link rel="stylesheet" href="../../assets/css/view_applications.css">
</head>
<body>

<nav class="navbar">
        <div class="navbar-container">
            <h1 class="navbar-title">Job Seeker Dashboard</h1>
            <ul class="navbar-links">
                <li><a href="../../pages/jobseeker_dashboard/jobseeker_dashboard.html">Dashboard</a></li>
                <li><a href="../../pages/search/search.html">Search Jobs</a></li>
                <li><a href="../search/view_applications.php">View Applications</a></li>
                <li><a href="../../pages/jobseeker_dashboard/jobseeker_profile.php">Profile</a></li>
                <li><button id="logout-btn">Logout</button></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>My Applications</h1>

        <?php if (count($applications) > 0): ?>
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Employer Name</th>
                        <th>Location</th>
                        <th>Job Type</th>
                        <th>Salary Range</th>
                        <th>Application Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['title']); ?></td>
                            <td><?php echo htmlspecialchars($application['employer_name']); ?></td>
                            <td><?php echo htmlspecialchars($application['location']); ?></td>
                            <td><?php echo htmlspecialchars($application['job_type']); ?></td>
                            <td><?php echo htmlspecialchars($application['salary_range']); ?></td>
                            <td><?php echo htmlspecialchars($application['application_deadline']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You haven't applied for any jobs yet..</p>
        <?php endif; ?>
    </div>
    <script>
        document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        });
    </script>
</body>
</html>
