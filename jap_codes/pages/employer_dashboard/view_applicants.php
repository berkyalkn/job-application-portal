<?php

session_start();
include '../../db/config.php';

if (!isset($_SESSION['username'])) {
    echo "User not authenticated";
    exit;
}

$username = $_SESSION['username']; 

$query = "
    SELECT a.username, a.application_date, j.title AS job_title
    FROM applications a
    JOIN jobs j ON a.job_id = j.job_id
    WHERE j.employer_name = '$username'
    ORDER BY a.application_date DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <link rel="stylesheet" href="../../assets/css/view_applicants.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <h1 class="navbar-title">Employer Dashboard</h1>
        <ul class="navbar-links">
            <li><a href="../../pages/employer_dashboard/employer_dashboard.html">Dashboard</a></li>
            <li><a href="../../pages/employer_dashboard/post_job.php">Post a Job</a></li>
            <li><a href="../../pages/employer_dashboard/manage_jobs.php">Manage Jobs</a></li>
            <li><a href="../../pages/employer_dashboard/view_applicants.php">View Applicants</a></li>
            <li><a href="../../pages/employer_dashboard/employer_profile.php">Profile</a></li>
            <li><button id="logout-btn">Logout</button></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>View Applications</h1>
    
    <table class="applicants-table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Applicant Username</th>
                <th>Application Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['application_date']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
        document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        });
</script>
</body>
</html>
