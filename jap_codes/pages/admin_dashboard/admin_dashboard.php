<?php
session_start();
include '../../db/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../../pages/login/login.html');
    exit;
}

$sqlJobs = "SELECT COUNT(*) AS total_jobs FROM jobs";
$resultJobs = $conn->query($sqlJobs);
$totalJobs = ($resultJobs->num_rows > 0) ? $resultJobs->fetch_assoc()['total_jobs'] : 0;

$sqlEmployers = "SELECT COUNT(*) AS total_employers FROM users WHERE role ='employer'";
$resultEmployers = $conn->query($sqlEmployers);
$totalEmployers = ($resultEmployers->num_rows > 0) ? $resultEmployers->fetch_assoc()['total_employers'] : 0;

$sqlJobSeekers = "SELECT COUNT(*) AS total_job_seekers FROM users WHERE role ='job_seeker'";
$resultJobSeekers = $conn->query($sqlJobSeekers);
$totalJobSeekers = ($resultJobSeekers->num_rows > 0) ? $resultJobSeekers->fetch_assoc()['total_job_seekers'] : 0;

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Job Platform</title>
    <link rel="stylesheet" href="../../assets/css/admin/admin_dashboard.css">
    <style>
    
.manage-links-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 32px;
    margin-top: 32px;
}

.manage-link-card {
    background-color: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.manage-link-card h3 {
    color: rgb(17, 48, 101); 
    margin-bottom: 16px;
}

.manage-link-card p {
    font-size: 16px;
    color: #333;
    margin-bottom: 16px;
}

.manage-link-card .btn {
    padding: 10px 20px;
    background-color: rgb(17, 48, 101);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}

.manage-link-card .btn:hover {
    background-color: #0056b3;
}
    </style>    
</head>
<body>
    <nav class="navbar">
    <h1 class="navbar-title">Admin Dashboard</h1>
        <ul class="nav-links">
            <li><a href="../admin_dashboard/admin_dashboard.php">Dashboard</a></li>
            <li><a href="../admin_dashboard/admin_employer.php">Manage Employers</a></li>
            <li><a href="../admin_dashboard/admin_jobseeker.php">Manage Job Seekers</a></li>
            <li><button id="logout-btn">Logout</button></li>
        </ul>
    </nav>

    <main class="dashboard">
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Jobs</h3>
                <p id="totalJobs"><?php echo $totalJobs; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Employers</h3>
                <p id="totalEmployers"><?php echo $totalEmployers; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Job Seekers</h3>
                <p id="totalJobSeekers"><?php echo $totalJobSeekers; ?></p>
            </div>
        </div>

       
         <div class="manage-links-container">
            <div class="manage-link-card">
                <h3>Manage Employers</h3>
                <p>Click below to manage employers in the platform.</p>
                <a href="../admin_dashboard/admin_employer.php" class="btn">Go to Manage Employers</a>
            </div>
            <div class="manage-link-card">
                <h3>Manage Job Seekers</h3>
                <p>Click below to manage job seekers in the platform.</p>
                <a href="../admin_dashboard/admin_jobseeker.php" class="btn">Go to Manage Job Seekers</a>
            </div>
        </div>

    </main>
    <script>
        document.getElementById('logout-btn').addEventListener('click', () => {
        window.location.href = "../../pages/login/login.html";
        })
    </script>
</body>
</html>

