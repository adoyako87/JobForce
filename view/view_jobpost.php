<?php
include '../includes/dbconn.php';
session_start();

// Ensure user_id is set in session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// Get the job ID from the query parameter
if (!isset($_GET['job_id'])) {
    die("Job ID not specified");
}

$job_id = $_GET['job_id'];

// Fetch the job post data
$sql = "SELECT * FROM jobpost WHERE id = ? AND IsDeleted = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No job post found");
}

$job_post = $result->fetch_assoc();

// Fetch industries and positions for displaying
$industries_sql = "SELECT id, industry_name FROM job_industries";
$industries_result = $conn->query($industries_sql);
$positions_sql = "SELECT id, position_name FROM job_positions";
$positions_result = $conn->query($positions_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/jobpost.css">
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f2ef; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; overflow-y: auto;">
    <div class="job-post-container">
        <h2 class="job-post-title">View Job Post</h2>
        <form class="job-post-form">
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="job_title">Job Title</label>
                    <select id="job_title" name="job_title" required class="job-post-select" disabled>
                        <?php
                        if ($positions_result->num_rows > 0) {
                            while($row = $positions_result->fetch_assoc()) {
                                $selected = ($row["position_name"] == $job_post["job_positions"]) ? "selected" : "";
                                echo "<option value='" . $row["position_name"] . "' $selected>" . $row["position_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="job-post-group">
                    <label for="recruiter">Recruiter</label>
                    <input type="text" id="recruiter" name="recruiter" required class="job-post-input" value="<?php echo htmlspecialchars($job_post['recruitment']); ?>" disabled>
                </div>
            </div>
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="job_type">Job Type</label>
                    <select id="job_type" name="job_type" required class="job-post-select" disabled>
                        <option value="Full-Time" <?php if ($job_post['job_category'] == "Full-Time") echo "selected"; ?>>Full-Time</option>
                        <option value="Part-Time" <?php if ($job_post['job_category'] == "Part-Time") echo "selected"; ?>>Part-Time</option>
                    </select>
                </div>
            </div>
            <div class="job-post-group">
                <label for="benefits">Benefits</label>
                <input type="text" id="benefits" name="benefits" required class="job-post-input" value="<?php echo htmlspecialchars($job_post['Benifits']); ?>" disabled>
            </div>
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" required class="job-post-input" value="<?php echo htmlspecialchars($job_post['location']); ?>" disabled>
                </div>
                <div class="job-post-group">
                    <label for="sectors">Sectors</label>
                    <select id="sectors" name="sectors" required class="job-post-select" disabled>
                        <?php
                        if ($industries_result->num_rows > 0) {
                            while($row = $industries_result->fetch_assoc()) {
                                $selected = ($row["industry_name"] == $job_post["job_category"]) ? "selected" : "";
                                echo "<option value='" . $row["industry_name"] . "' $selected>" . $row["industry_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="job-post-group">
                <label for="job_description">Job Description</label>
                <textarea id="job_description" name="job_description" required class="job-post-textarea" disabled><?php echo htmlspecialchars($job_post['Post_Description']); ?></textarea>
            </div>
            <div class="job-post-section">
               
                <div class="job-post-group">
                    <label for="salary_from">Salary</label>
                    <input type="text" id="salary_from" name="salary_from" placeholder="Enter salary" required class="job-post-input" value="<?php echo htmlspecialchars($job_post['salary']); ?>" disabled>
                </div>
            </div>
            <div class="job-post-group">
                <label for="education">Education Level</label>
                <select id="education" name="education" required class="job-post-select" disabled>
                    <option value="Ordinary Level" <?php if ($job_post['education'] == "Ordinary Level") echo "selected"; ?>>Ordinary Level</option>
                    <option value="Advanced Level" <?php if ($job_post['education'] == "Advanced Level") echo "selected"; ?>>Advanced Level</option>
                    <option value="HND" <?php if ($job_post['education'] == "HND") echo "selected"; ?>>HND</option>
                    <option value="Bachelors" <?php if ($job_post['education'] == "Bachelors") echo "selected"; ?>>Bachelors</option>
                    <option value="Masters" <?php if ($job_post['education'] == "Masters") echo "selected"; ?>>Masters</option>
                    <option value="PhD" <?php if ($job_post['education'] == "PhD") echo "selected"; ?>>PhD</option>
                </select>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="view_jobpost_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>
