<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

<div class="admin-dashboard">

    <!-- Sidebar -->
    <aside class="admin-sidebar">

        <h2>Admin Panel</h2>
        <p>Hospital Management System</p>

        <a href="adminDashboard.php" class="active">
            Dashboard
        </a>

        <a href="manageUsers.php">
            Manage Users
        </a>

        <a href="../../rahim/view/adminDoctorDashboard.php">
            Manage Doctors
        </a>

        <a href="../../rahim/view/manageSpecialization.php">
            Specializations
        </a>

        <a href="../../hasan/view/adminAppointments.php">
            Appointments
        </a>

        <a href="../controller/logoutController.php" class="logout">
            Logout
        </a>

    </aside>

    <!-- Main -->
    <main class="admin-main">

        <div class="admin-header">
            <h1>
                Welcome, <?php echo $_SESSION["name"]; ?>
            </h1>

            <p>
                Manage hospital users, doctors,
                specializations and appointments.
            </p>
        </div>

        <div class="admin-cards">

            <div class="admin-card">
                <h3>Manage Users</h3>

                <p>
                    Activate or deactivate
                    patient, doctor, and admin accounts.
                </p>

                <a href="manageUsers.php">
                    Open Module
                </a>
            </div>

            <div class="admin-card">
                <h3>Manage Doctors</h3>

                <p>
                    Add, update and manage doctor
                    information and schedules.
                </p>

                <a href="../../arnob/view/doctor.php">
                    Open Module
                </a>
            </div>

            <div class="admin-card">
                <h3>Specializations</h3>

                <p>
                    Create and manage doctor
                    specializations for the system.
                </p>

                <a href="../../arnob/view/specialization.php">
                    Open Module
                </a>
            </div>

            <div class="admin-card">
                <h3>Appointments</h3>

                <p>
                    Monitor, confirm or cancel
                    patient appointments.
                </p>

                <a href="../../hasan/view/adminAppointments.php">
                    Open Module
                </a>
            </div>

        </div>

    </main>

</div>

</body>

</html>