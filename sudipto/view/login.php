<?php
session_start();

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Hospital Appointment System</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

    <div class="login-container">

        <div class="login-left">
            <div class="badge">Your Health, Our Priority</div>
            <h1>Welcome Back</h1>
            <p>Login to manage your appointments, doctor schedules, and hospital services.</p>

            <div class="features">
                <div>✔ Book appointments easily</div>
                <div>✔ View doctor availability</div>
                <div>✔ Manage medical schedules</div>
            </div>
        </div>

        <div class="login-box">
            <?php
            if (isset($_SESSION["successMsg"])) {
                echo "<p class='success-msg'>" . $_SESSION["successMsg"] . "</p>";
                unset($_SESSION["successMsg"]);
            }
            ?>
            <h2>Login</h2>
            <p class="subtitle">Access your hospital account</p>

            <form action="" method="post">
                <label>Email Address</label>
                <div class="input-group">
                    <span>✉</span>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>

                <label>Password</label>
                <div class="input-group">
                    <span></span>
                    <input type="password" name="password" placeholder="Enter your password">
                </div>

                <div class="options">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit">Login</button>
            </form>

            <p class="register-text">
                New patient? <a href="./registration.php">Create account</a>
            </p>
        </div>

    </div>

</body>

</html>