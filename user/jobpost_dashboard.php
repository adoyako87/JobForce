<?php
include '../includes/dbconn.php';
session_start();

// Ensure user_id is set in session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];

// Fetch job posts created by the specific user
$sql = "SELECT id, job_positions, job_category, Benifits, salary FROM jobpost WHERE IsDeleted = 0 AND CreatedBy = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Error executing query: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f2ef;
            padding: 20px;
        }
        .job-widget {
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .job-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .job-widget h4 {
            margin-bottom: 15px;
        }
        .job-widget p {
            margin: 5px 0;
        }
        .job-widget .btn-view {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Job Dashboard</h1>
        <a href="job_post.php" class="btn btn-primary mb-4">Create a Job Post</a>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='job-widget'>";
                echo "<h4>" . htmlspecialchars($row["job_positions"]) . "</h4>";
                echo "<p><strong>Category:</strong> " . htmlspecialchars($row["job_category"]) . "</p>";
                echo "<p><strong>Benefits:</strong> " . htmlspecialchars($row["Benifits"]) . "</p>";
                echo "<p><strong>Salary:</strong> $" . number_format($row["salary"]) . "</p>";
                echo "<a href='edit_jobpost.php?job_id=" . htmlspecialchars($row["id"]) . "' class='btn btn-secondary btn-view'>Edit Details</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No job posts found.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
