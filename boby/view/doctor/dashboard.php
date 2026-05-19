<?php
require_once __DIR__ . '/../../controller/DoctorDashboardController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="home-body">

<div class="container">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <span class="hero-badge">Doctor Panel</span>
                <h2>Today's Appointments</h2>
            </div>

            <div class="welcome-profile">
                Welcome, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
                |
                <a href="weekly_schedule.php" class="logout-link">Weekly Schedule</a>
                |
                <a href="../../../sudipto/controller/logoutController.php" class="logout-link">Logout</a>
            </div>
        </div>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($todayAppointments) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($todayAppointments)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                        <td><?= htmlspecialchars($row['patient_name']) ?></td>
                        <td><?= htmlspecialchars($row['reason']) ?></td>
                        <td>
                            <span id="status-<?= $row['id'] ?>" class="status-badge <?= strtolower(str_replace([' ', '-'], '', $row['status'])) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn-complete" onclick="updateStatus(<?= $row['id'] ?>, 'Completed')">Mark Completed</button>
                                <button type="button" class="btn-noshow" onclick="updateStatus(<?= $row['id'] ?>, 'No-Show')">Mark No-Show</button>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding:25px; color:#6c757d;">No appointments for today.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateStatus(id, status) {
    fetch("../../api/appointments/update_status.php?id=" + id, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            const badge = document.getElementById("status-" + id);
            badge.innerText = data.new_status;
            badge.className = "status-badge " + data.new_status.toLowerCase().replace(/[\s-]+/g, "");
            alert("Status updated successfully");
        } else {
            alert(data.message);
        }
    })
    .catch(() => alert("Something went wrong."));
}
</script>

</body>
</html>
