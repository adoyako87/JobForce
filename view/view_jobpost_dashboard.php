<?php
include '../includes/dbconn.php';
session_start();

// Fetch all job posts and their corresponding user details
$sql = "SELECT jobpost.id, jobpost.job_positions, jobpost.job_category, jobpost.Benifits, jobpost.salary, jobpost.CreatedBy, user.username 
        FROM jobpost 
        INNER JOIN user ON jobpost.CreatedBy = user.id 
        WHERE jobpost.IsDeleted = 0";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

// Handle deletion of a job post
if (isset($_GET['delete_job_id'])) {
    $delete_job_id = $_GET['delete_job_id'];
    $delete_sql = "UPDATE jobpost SET IsDeleted = 1 WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $delete_job_id);
    
    if ($delete_stmt->execute()) {
        echo "<script>alert('Job post deleted successfully'); window.location.href='admin_jobpost_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $delete_stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewer Job Dashboard</title>
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
        .job-widget .btn-view,
        .job-widget .btn-delete {
            margin-top: 15px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Viewer Job Dashboard</h1>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='job-widget'>";
                echo "<h4>" . htmlspecialchars($row["job_positions"]) . "</h4>";
                echo "<p><strong>Category:</strong> " . htmlspecialchars($row["job_category"]) . "</p>";
                echo "<p><strong>Benefits:</strong> " . htmlspecialchars($row["Benifits"]) . "</p>";
                echo "<p><strong>Salary:</strong> $" . number_format($row["salary"]) . "</p>";
                echo "<p><strong>Created By:</strong> " . htmlspecialchars($row["username"]) . "</p>";
                echo "<a href='view_jobpost.php?job_id=" . htmlspecialchars($row["id"]) . "' class='btn btn-secondary btn-view'>View Job</a>";
                
                echo "</div>";
            }
        } else {
            echo "<p>No job posts found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
