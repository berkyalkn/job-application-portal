<?php

session_start();
include '../../db/config.php';

$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$userData = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dateofbirth = $_POST['dateofbirth'];
    $phonenumber = $_POST['phonenumber'];
    $country = $_POST['country'];
    $city = $_POST['city'];


    $updateQuery = "UPDATE users SET first_name = ?, last_name = ?, gender = ?, date_of_birth = ?, 
                    phone_number = ?, country = ?, city = ? WHERE username = ?";
    
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('ssssssss', $firstname, $lastname, $gender, $dateofbirth, $phonenumber, $country, $city, $username);

    if ($updateStmt->execute()) {
        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "There was an error updating your profile.";
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../assets/css/jobseeker_profile.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <h1 class="navbar-title">Job Seeker Dashboard</h1>
            <ul class="navbar-links">
                <li><a href="../../pages/jobseeker_dashboard/jobseeker_dashboard.html">Dashboard</a></li>
                <li><a href="../../pages/search/search.html">Search Jobs</a></li>
                <li><a href="../jobseeker_dashboard/view_applications.php">View Applications</a></li>
                <li><a href="../../pages/jobseeker_dashboard/jobseeker_profile.php">Profile</a></li>
                <li><button id="logout-btn">Logout</button></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Job Seeker Profile</h1>

        <?php if (isset($successMessage)): ?>
            <p><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form action="jobseeker_profile.php" method="POST">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo $userData['first_name']; ?>" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo $userData['last_name']; ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male" <?php echo $userData['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $userData['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $userData['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="dateofbirth">Date of Birth:</label>
            <input type="date" id="dateofbirth" name="dateofbirth" value="<?php echo $userData['date_of_birth']; ?>" required>

            <label for="phonenumber">Phone Number:</label>
            <input type="tel" id="phonenumber" name="phonenumber" value="<?php echo $userData['phone_number']; ?>" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $userData['country']; ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $userData['city']; ?>" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <script>
        document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        });
    </script>
</body>
</html>
