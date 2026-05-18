<?php

session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$userModel = new UserModel();

$result = $userModel->getAllUsers(
    $connection,
    "users"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

    <div class="manage-users-container">

        <div class="manage-users-box">

            <div class="manage-header">
                <h1>Manage Users</h1>

                <a href="adminHome.php">
                    Back Dashboard
                </a>
            </div>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php while ($user = $result->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?php echo $user["id"]; ?>
                        </td>

                        <td>
                            <?php echo $user["name"]; ?>
                        </td>

                        <td>
                            <?php echo $user["email"]; ?>
                        </td>

                        <td>
                            <?php echo ucfirst($user["role"]); ?>
                        </td>

                        <td id="status-<?php echo $user['id']; ?>">
                            <?php
                            if ($user["is_active"] == 1) {
                                echo "Active";
                            } else {
                                echo "Inactive";
                            }
                            ?>
                        </td>

                        <td>

                            <?php if ($user["id"] == $_SESSION["user_id"]) { ?>

                                <span class="current-admin">
                                    Current Admin
                                </span>

                            <?php } else { ?>

                                <?php if ($user["is_active"] == 1) { ?>

                                    <button class="toggle-btn"
                                        data-user-id="<?php echo $user['id']; ?>">
                                        Deactivate
                                    </button>

                                <?php } else { ?>

                                    <button class="toggle-btn"
                                        data-user-id="<?php echo $user['id']; ?>">
                                        Activate
                                    </button>

                                <?php } ?>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

    <script src="../controller/toggleUserStatus.js"></script>

</body>

</html>