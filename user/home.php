<?php
session_start();

// Check if user is logged in and get user ID from session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Database connection
include '../includes/dbconn.php';

// Fetch user details
$sql = "SELECT First_Name, Last_Name, about, username FROM user WHERE ID = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $about, $username);
$stmt->fetch();
$stmt->close();

// Store username in session
$_SESSION['username'] = $username;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Job Force</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
    <div class="container">
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></h2>
            <p><?php echo htmlspecialchars($about); ?></p>
            <a href="jobpost_dashboard.php" class="btn">Post a Job</a>
            <a href="submit_ticket.php" class="btn">Post a Job</a>
        </div>
    </div>
</body>
</html>
