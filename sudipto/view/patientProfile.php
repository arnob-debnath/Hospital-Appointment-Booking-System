<?php
session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "patient") {
    header("Location: login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$userModel = new UserModel();

$result = $userModel->getUserById(
    $connection,
    "users",
    $_SESSION["user_id"]
);

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

<div class="profile-container">

    <div class="profile-box">

        <h2>My Profile</h2>
        <p class="subtitle">Update your information and manage password</p>

        <?php
        if (isset($_SESSION["profileSuccess"])) {
            echo "<p class='success-msg'>" . $_SESSION["profileSuccess"] . "</p>";
            unset($_SESSION["profileSuccess"]);
        }

        if (isset($_SESSION["profileErr"])) {
            echo "<p class='error-msg'>" . $_SESSION["profileErr"] . "</p>";
            unset($_SESSION["profileErr"]);
        }
        ?>

        <div class="profile-flex">

            <!-- Profile Update Section -->
            <div class="profile-card">
                <h3>Profile Information</h3>

                <form action="../controller/patientProfileController.php" method="post">

                    <input type="hidden" name="action" value="update_profile">

                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo $user['name']; ?>">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["profileNameErr"] ?? "";
                        unset($_SESSION["profileNameErr"]);
                        ?>
                    </span>

                    <label>Email</label>
                    <input type="email" value="<?php echo $user['email']; ?>" readonly>

                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $user['phone']; ?>">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["profilePhoneErr"] ?? "";
                        unset($_SESSION["profilePhoneErr"]);
                        ?>
                    </span>

                    <label>Date of Birth</label>
                    <input type="date" name="dob" value="<?php echo $user['dob']; ?>">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["profileDobErr"] ?? "";
                        unset($_SESSION["profileDobErr"]);
                        ?>
                    </span>

                    <label>Blood Group</label>
                    <input type="text" value="<?php echo $user['blood_group']; ?>" readonly>

                    <button type="submit">Update Profile</button>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="profile-card">
                <h3>Change Password</h3>

                <form action="../controller/patientProfileController.php" method="post">

                    <input type="hidden" name="action" value="change_password">

                    <label>Current Password</label>
                    <input type="password" name="current_password">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["currentPasswordErr"] ?? "";
                        unset($_SESSION["currentPasswordErr"]);
                        ?>
                    </span>

                    <label>New Password</label>
                    <input type="password" name="new_password">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["newPasswordErr"] ?? "";
                        unset($_SESSION["newPasswordErr"]);
                        ?>
                    </span>

                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">
                    <span class="field-error">
                        <?php
                        echo $_SESSION["confirmPasswordErr"] ?? "";
                        unset($_SESSION["confirmPasswordErr"]);
                        ?>
                    </span>

                    <button type="submit">Change Password</button>
                </form>
            </div>

        </div>

        <p class="back-link">
            <a href="patientHome.php">Back to Dashboard</a>
        </p>

    </div>

</div>

</body>
</html>