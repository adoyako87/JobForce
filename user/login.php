<?php
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (username, Email, Password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hash);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $user_id = mysqli_insert_id($conn); // Get the ID of the newly created user
            session_start();
            $_SESSION['user_id'] = $user_id; // Store user ID in session
            header("Location: register.php"); // Redirect to register.php
        } else {
            echo "<p>Error: Unable to register. Please try again.</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Error preparing statement: " . mysqli_error($conn) . "</p>";
    }
    mysqli_close($conn);
} else {
    // Not a POST request, redirect back to login.php
    //header("Location: ../login.php");
}
?>






<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../assets/css/style.css">
        <title>Job Force</title>
    </head>
    <body>

        <div class="container">

            <div class="signin-signup">
                <form action="" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-filed">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username">
                    </div>
                    <div class="input-filed">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Log in" class="btn">
                    <p class="social-text">Or signup with social platform</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
                </form>
                <form action="login.php" method="post" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <div class="input-filed">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-filed">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-filed">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <input type="submit" value="Sign up" class="btn">
                    <p class="social-text">Or signup with social platform</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
                </form>
            </div>
            <div class="panel-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Find</h3>
                        <p>asdamsmdamsdkaksmdasd</p>
                        <button class="btn" id="sign-in-btn">Sign in</button>
                    </div>
                    <img src="image/1.png" alt="" class="image">
                </div>
                <div class="panel right-panel">
                    <div class="content">
                        <h3>Join with us</h3>
                        <p>asdamsmdamsdkaksmdasd</p>
                        <button class="btn" id="sign-up-btn">Sign in</button>
                    </div>
                    <img src="image/2.png" alt="" class="image">
                </div>
            </div>
        </div>

        <script src="../assets/js/app.js"></script>

    </body>
</html>