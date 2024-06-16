
<?php
session_start();

// Check if user is logged in and get user ID from session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Job Force</title>
    <link rel="stylesheet" href="../assets/css/kp.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f2ef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-top: 0;
            color: #333;
            font-size: 1.8em;
            font-weight: bold;
        }

        p {
            color: #666;
            font-size: 1em;
            margin: 20px 0;
        }

        .btn {
            background-color: #0073b1;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            margin: 20px 0 10px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #005582;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Job Force</h2>
        <p>You have successfully logged in. Explore our platform and find the best job opportunities for you.</p>
    </div>
</body>
</html>
