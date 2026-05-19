<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../../../sudipto/view/login.php");
    exit();
}

require_once __DIR__ . '/../../model/AppointmentModel.php';

$weeklyAppointments = getWeeklyAppointments($_SESSION['user_id']);

$days = [
    'Monday' => [],
    'Tuesday' => [],
    'Wednesday' => [],
    'Thursday' => [],
    'Friday' => []
];

while ($row = mysqli_fetch_assoc($weeklyAppointments)) {
    $dayName = date('l', strtotime($row['appointment_date']));

    if (isset($days[$dayName])) {
        $days[$dayName][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Schedule</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="home-body">

<div class="container">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <span class="hero-badge">Doctor Panel</span>
                <h2>Weekly Schedule</h2>
            </div>
            <div class="welcome-profile">
                <a href="dashboard.php" class="logout-link">Back to Dashboard</a>
                |
                <a href="../../../sudipto/controller/logoutController.php" class="logout-link">Logout</a>
            </div>
        </div>

        <div class="weekly-grid">
            <?php foreach ($days as $day => $appointments): ?>
                <div class="day-column">
                    <h3><?= $day ?></h3>

                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $app): ?>
                            <div class="appointment-block" onclick="showDetails(
                                '<?= htmlspecialchars($app['patient_name'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($app['reason'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($app['appointment_date'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($app['appointment_time'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($app['status'], ENT_QUOTES) ?>'
                            )">
                                <strong><?= htmlspecialchars($app['appointment_time']) ?></strong><br>
                                <?= htmlspecialchars($app['patient_name']) ?><br>
                                <span><?= htmlspecialchars($app['status']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No booking</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function showDetails(patient, reason, date, time, status) {
    alert(
        "Patient: " + patient +
        "\nReason: " + reason +
        "\nDate: " + date +
        "\nTime: " + time +
        "\nStatus: " + status
    );
}
</script>

</body>
</html>
