<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "patient") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>

<div class="patient-dashboard">

    <aside class="dashboard-sidebar">
        <h2>Hospital System</h2>
        <p>Your Health, Our Priority</p>

        <a href="patientHome.php" class="active">Dashboard</a>
        <a href="patientProfile.php">My Profile</a>
        <a href="../../karim/view/browseDoctors.php">Browse Doctors</a>
        <a href="../../karim/view/myAppointments.php">My Appointments</a>
        <a href="../controller/logoutController.php" class="logout">Logout</a>
    </aside>

    <main class="dashboard-main">

        <div class="dashboard-header">
            <div>
                <h1>Welcome, <?php echo $_SESSION["name"]; ?></h1>
                <p><?php echo $_SESSION["email"]; ?></p>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="dash-card">
                <h3>Book Appointment</h3>
                <p>Find doctors and book your appointment easily.</p>
                <a href="../../karim/view/browseDoctors.php">Browse Doctors</a>
            </div>

            <div class="dash-card">
                <h3>My Appointments</h3>
                <p>View your upcoming and past appointments.</p>
                <a href="../../karim/view/myAppointments.php">View Appointments</a>
            </div>

            <div class="dash-card">
                <h3>My Profile</h3>
                <p>Update your personal information and password.</p>
                <a href="patientProfile.php">Update Profile</a>
            </div>
        </div>

    </main>

</div>

</body>
</html>