<?php

session_start();
include '../../db/config.php';

if (!isset($_SESSION['username'])) {
    echo "User not authenticated";
    exit;
}

$username = $_SESSION['username']; 
$query = "SELECT * FROM jobs WHERE employer_name = '$username'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $salary_range = mysqli_real_escape_string($conn, $_POST['salary_range']);
        $application_deadline = mysqli_real_escape_string($conn, $_POST['application_deadline']);
        $industry = mysqli_real_escape_string($conn, $_POST['industry']);
        $benefits = mysqli_real_escape_string($conn, $_POST['benefits']);

        $updateQuery = "
            UPDATE jobs SET 
                title = '$title',
                location = '$location',
                job_type = '$job_type',
                description = '$description',
                salary_range = '$salary_range',
                application_deadline = '$application_deadline',
                industry = '$industry',
                benefits = '$benefits'
            WHERE employer_name = '$username' AND title = '$title'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "Job updated successfully!";
        } else {
            echo "Error updating job: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['delete'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $username = $_SESSION['username']; 

        $deleteQuery = "DELETE FROM jobs WHERE title = '$title' AND employer_name = '$username'";

        if (mysqli_query($conn, $deleteQuery)) {
            echo "Job deleted successfully!";
            header("Location: manage_jobs.php");
            exit;
        } else {
            echo "Error deleting job: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="../../assets/css/manage_jobs.css">
    <script>
        function populateEditForm(job) {
            document.getElementById('title').value = job.title;
            document.getElementById('location').value = job.location;
            document.getElementById('job_type').value = job.job_type;
            document.getElementById('description').value = job.description;
            document.getElementById('salary_range').value = job.salary_range;
            document.getElementById('application_deadline').value = job.application_deadline;
            document.getElementById('industry').value = job.industry;
            document.getElementById('benefits').value = job.benefits;

            document.getElementById('edit-form').style.display = 'block';
        }
    </script>
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
    <h1>Manage Your Jobs</h1>
    

    <div class="job-list">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="job">
                <h2><?php echo $row['title']; ?></h2>
                <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                <p><strong>Job Type:</strong> <?php echo $row['job_type']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                <p><strong>Salary Range:</strong> <?php echo $row['salary_range']; ?></p>
                <p><strong>Application Deadline:</strong> <?php echo $row['application_deadline']; ?></p>
                <p><strong>Industry:</strong> <?php echo $row['industry']; ?></p>
                <p><strong>Benefits:</strong> <?php echo $row['benefits']; ?></p>

                <button onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="title" value="<?php echo $row['title']; ?>">
                    <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this job?');">Delete</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <div id="edit-form" style="display:none;">
        <h2>Edit Job</h2>
        <form method="POST">
            <label for="title">Job Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="job_type">Job Type:</label>
            <select id="job_type" name="job_type" required>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Internship">Remote</option>
            </select>

            <label for="description">Job Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="salary_range">Salary Range:</label>
            <input type="text" id="salary_range" name="salary_range" required>

            <label for="application_deadline">Application Deadline:</label>
            <input type="date" id="application_deadline" name="application_deadline" required>

            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry" required>

            <label for="benefits">Benefits:</label>
            <textarea id="benefits" name="benefits" rows="3"></textarea>

            <button type="submit" name="edit">Update Job</button>
        </form>
    </div>
</div>
<script>
        document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        });
</script>
</body>
</html>
