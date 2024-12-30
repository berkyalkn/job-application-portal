<?php

session_start();
include '../../db/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "User not authenticated or not an admin.";
    exit;
}

$query = "SELECT * FROM users WHERE role = 'job_seeker'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);

        $updateQuery = "UPDATE users SET email = '$email', first_name = '$first_name', last_name = '$last_name', 
                        gender = '$gender', date_of_birth = '$date_of_birth', phone_number = '$phone_number', 
                        country = '$country', city = '$city' WHERE username = '$username' AND role = 'job_seeker'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "Job Seeker information updated successfully!";
        } else {
            echo "Error updating job seeker information: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['delete'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $deleteQuery = "DELETE FROM users WHERE username = '$username' AND role = 'job_seeker'";

        if (mysqli_query($conn, $deleteQuery)) {
            echo "Job Seeker deleted successfully!";
            header("Location: admin_jobseeker.php");
            exit;
        } else {
            echo "Error deleting job seeker: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Job Seekers</title>
    <link rel="stylesheet" href="../../assets/css/admin/admin_jobseeker.css">
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

<div class="container">
    <h1>Manage Job Seekers</h1>

    <div class="jobseeker-list">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="jobseeker">
                <h2><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h2>
                <p><strong>Username:</strong> <?php echo $row['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $row['date_of_birth']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $row['phone_number']; ?></p>
                <p><strong>Country:</strong> <?php echo $row['country']; ?></p>
                <p><strong>City:</strong> <?php echo $row['city']; ?></p>

                <button onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                    <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this job seeker?');">Delete</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <div id="edit-form" style="display:none;">
        <h2>Edit Job Seeker Information</h2>
        <form method="POST">
            <input type="hidden" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <button type="submit" name="edit">Update Information</button>
        </form>
    </div>
</div>

<script>
    function populateEditForm(jobseeker) {
        document.getElementById('username').value = jobseeker.username;
        document.getElementById('email').value = jobseeker.email;
        document.getElementById('first_name').value = jobseeker.first_name;
        document.getElementById('last_name').value = jobseeker.last_name;
        document.getElementById('gender').value = jobseeker.gender;
        document.getElementById('date_of_birth').value = jobseeker.date_of_birth;
        document.getElementById('phone_number').value = jobseeker.phone_number;
        document.getElementById('country').value = jobseeker.country;
        document.getElementById('city').value = jobseeker.city;

        document.getElementById('edit-form').style.display = 'block';
    }

    document.getElementById('logout-btn').addEventListener('click', () => {
        window.location.href = "../../pages/login/login.html";
    });
</script>

</body>
</html>
