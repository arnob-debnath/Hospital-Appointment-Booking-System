<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="patient.css">
    <link rel="stylesheet" href="../view/styles/style.css">
</head>

<body>

    <div class="container">
        <div class="left-section">
            <h1>Hospital Appointment System</h1>
            <p>Create your patient account and book appointments with trusted doctors.</p>

        </div>

        <div class="form-box">
            <h2>Patient Registration</h2>
            <p class="subtitle">Fill up your information carefully</p>

            <form action="../controller/registerController.php" method="post">

                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name"
                    value="<?php echo $_SESSION['name'] ?? ''; ?>">
                <span><?php echo $_SESSION['nameErr'] ?? ''; ?></span>

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email"
                    value="<?php echo $_SESSION['email'] ?? ''; ?>">
                <span>
                    <?php
                    echo $_SESSION['emailErr'] ?? '';
                    echo $_SESSION['emailExistsErr'] ?? '';
                    ?>
                </span>

                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password">
                <span><?php echo $_SESSION['passwordErr'] ?? ''; ?></span>

                <label>Date of Birth</label>
                <input type="date" name="dob"
                    value="<?php echo $_SESSION['dob'] ?? ''; ?>">
                <span><?php echo $_SESSION['dobErr'] ?? ''; ?></span>

                <label>Blood Group</label>
                <select name="blood_group">
                    <option value="">Select Blood Group</option>

                    <option value="A+" <?php if (($_SESSION['blood_group'] ?? '') == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if (($_SESSION['blood_group'] ?? '') == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if (($_SESSION['blood_group'] ?? '') == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if (($_SESSION['blood_group'] ?? '') == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if (($_SESSION['blood_group'] ?? '') == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if (($_SESSION['blood_group'] ?? '') == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if (($_SESSION['blood_group'] ?? '') == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if (($_SESSION['blood_group'] ?? '') == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>
                <span><?php echo $_SESSION['bloodErr'] ?? ''; ?></span>

                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="Enter phone number"
                    value="<?php echo $_SESSION['phone'] ?? ''; ?>">
                <span><?php echo $_SESSION['phoneErr'] ?? ''; ?></span>

                <button type="submit">Register</button>

            </form>

            <p class="login-text">
                Already have an account? <a href="./login.php">Login here</a>
            </p>
        </div>
    </div>

</body>

</html>