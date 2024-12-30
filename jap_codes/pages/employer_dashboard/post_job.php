<?php

session_start();
include('../../db/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employerName = $_POST['employer_name'];
    $jobTitle = $_POST['title'];
    $jobDescription = $_POST['description'];
    $salaryRange = $_POST['salary_range'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $jobType = $_POST['job_type'];
    $benefits = $_POST['benefits'];
    $applicationDeadline = $_POST['application_deadline'];

    if (empty($employerName) || empty($jobTitle) || empty($jobDescription) || empty($salaryRange) || 
        empty($industry) || empty($location) || empty($jobType) || empty($applicationDeadline)) {
        $error = "Please fill in the required fields.";
    } else {
        $query = "INSERT INTO jobs (employer_name, title, description, salary_range, industry, location, job_type, benefits, application_deadline, posted_date) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $employerName, $jobTitle, $jobDescription, $salaryRange, $industry, $location, $jobType, $benefits, $applicationDeadline);

        if ($stmt->execute()) {
            $success = "Job posting added successfully.";
        } else {
            $error = "An error occured: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting</title>
    <link rel="stylesheet" href="../../assets/css/manage_jobs.css">
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
        <h1>Post a Job</h1>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="post_job.php" method="POST" id="edit-form">
    <label for="employer_name">Employer Name:</label>
    <input type="text" id="employer_name" name="employer_name" placeholder="Enter employer name" required>

    <label for="title">Job Title:</label>
    <input type="text" id="title" name="title" placeholder="Enter job title" required>

    <label for="description">Job Description:</label>
    <textarea id="description" name="description" rows="4" placeholder="Enter job description" required></textarea>

    <label for="salary_range">Salary Range:</label>
    <input type="text" id="salary_range" name="salary_range" placeholder="e.g., $50,000 - $60,000" required>

    <label for="industry">Industry:</label>
    <input type="text" id="industry" name="industry" placeholder="e.g., IT, Healthcare" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" placeholder="Enter job location" required>

    <label for="job_type">Job Type:</label>
    <select id="job_type" name="job_type" required>
        <option value="" disabled selected>Select job type</option>
        <option value="Full-time">Full-time</option>
        <option value="Part-time">Part-time</option>
        <option value="Remote">Remote</option>
    </select>

    <label for="benefits">Benefits (optional):</label>
    <textarea id="benefits" name="benefits" rows="3" placeholder="e.g., Health Insurance, Remote Work"></textarea>

    <label for="application_deadline">Application Deadline:</label>
    <input type="date" id="application_deadline" name="application_deadline" required>

    <button type="submit">Post Job</button>
</form>
    </div>
</body>
<script>
        document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        });
</script>
</html>
