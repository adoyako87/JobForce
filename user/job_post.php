<?php
    include '../includes/dbconn.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $job_positions = $_POST['job_title'];
        $Post_Description = $_POST['job_description'];
        $recruitment = $_POST['recruiter'];
        $Benifits = $_POST['benefits'];
        $job_category = $_POST['job_type'];
        $Contact_Info = '';
        $location = $_POST['location'];
        $education = $_POST['education'];
        $salary = $_POST['salary_from'];
        $IsDeleted = 0;
        $CreatedOn = date('Y-m-d H:i:s');
        $CreatedBy = 'Admin';
    
        $sql = "INSERT INTO jobpost (job_positions, Post_Description, recruitment, Benifits, job_category, Contact_Info, location, education, salary, IsDeleted, CreatedOn, CreatedBy) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssisss", $job_positions, $Post_Description, $recruitment, $Benifits, $job_category, $Contact_Info, $location, $education, $salary, $IsDeleted, $CreatedOn, $CreatedBy);
    
        if ($stmt->execute()) {
            echo "New job post created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    
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
    <title>Job Post</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f2ef;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
        }
        .job-post-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }
        .job-post-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .job-post-form {
            display: flex;
            flex-direction: column;
        }
        .job-post-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .job-post-group {
            flex: 1;
            min-width: calc(50% - 10px);
            margin-bottom: 15px;
        }
        .job-post-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .job-post-input, .job-post-select, .job-post-textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .job-post-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .job-post-button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .job-post-group {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="job-post-container">
        <h2 class="job-post-title">Add Vacancy</h2>
        <form action="job_post.php" method="POST" enctype="multipart/form-data" class="job-post-form">
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="job_title">Job Title *</label>
                    <select id="job_title" name="job_title" required class="job-post-select">
                        <?php
                        if ($positions_result->num_rows > 0) {
                            while($row = $positions_result->fetch_assoc()) {
                                echo "<option value='" . $row["position_name"] . "'>" . $row["position_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="job-post-group">
                    <label for="recruiter">Recruiter *</label>
                    <input type="text" id="recruiter" name="recruiter" required class="job-post-input">
                </div>
            </div>
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="job_type">Job Type *</label>
                    <select id="job_type" name="job_type" required class="job-post-select">
                        <option value="Full-Time">Full-Time</option>
                        <option value="Part-Time">Part-Time</option>
                    </select>
                </div>
            </div>
            <div class="job-post-group">
                <label for="benefits">Benefits</label>
                <input type="text" id="benefits" name="benefits" class="job-post-input">
            </div>
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" required class="job-post-input">
                </div>
                <div class="job-post-group">
                    <label for="sectors">Sectors *</label>
                    <select id="sectors" name="sectors" required class="job-post-select">
                        <?php
                        if ($industries_result->num_rows > 0) {
                            while($row = $industries_result->fetch_assoc()) {
                                echo "<option value='" . $row["industry_name"] . "'>" . $row["industry_name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="job-post-group">
                <label for="job_description">Job Description</label>
                <textarea id="job_description" name="job_description" class="job-post-textarea"></textarea>
            </div>
            <div class="job-post-section">
                <div class="job-post-group">
                    <label for="experience_level">Experience Level</label>
                    <input type="text" id="experience_level" name="experience_level" class="job-post-input">
                </div>
                <div class="job-post-group">
                    <label for="salary_from">Salary Band From</label>
                    <input type="number" id="salary_from" name="salary_from" placeholder="From" class="job-post-input">
                </div>
            </div>
            <div class="job-post-group">
                <label for="education">Education Level</label>
                <select id="education" name="education" class="job-post-select">
                    <option value="Ordinary Level">Ordinary Level</option>
                    <option value="Advanced Level">Advanced Level</option>
                    <option value="HND">HND</option>
                    <option value="Bachelors">Bachelors</option>
                    <option value="Masters">Masters</option>
                    <option value="PhD">PhD</option>
                </select>
            </div>
            <div class="job-post-group">
                <button type="submit" class="job-post-button">Save Vacancy</button>
            </div>
        </form>
    </div>
</body>
</html>
