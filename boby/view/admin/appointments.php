<?php
require_once __DIR__ . '/../../controller/AdminAppointmentController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Appointment List</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="home-body">

<div class="container">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <span class="hero-badge">Admin Panel</span>
                <h2>Appointment Management</h2>
            </div>
            <div class="welcome-profile">
                <a href="../../../sudipto/view/adminHome.php" class="logout-link">Back Dashboard</a>
                |
                <a href="../../../sudipto/controller/logoutController.php" class="logout-link">Logout</a>
            </div>
        </div>

        <div class="filter-box">
            <form method="GET" class="filter-form">
                <select name="doctor_id">
                    <option value="">All Doctors</option>
                    <?php while ($doctor = mysqli_fetch_assoc($doctors)): ?>
                        <option value="<?= $doctor['id'] ?>" <?= $doctor_id == $doctor['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($doctor['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input type="date" name="date" value="<?= htmlspecialchars($date) ?>">

                <select name="status">
                    <option value="">All Status</option>
                    <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= $status == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Completed" <?= $status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Cancelled" <?= $status == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="No-Show" <?= $status == 'No-Show' ? 'selected' : '' ?>>No-Show</option>
                </select>

                <button type="submit" class="btn-confirm">Filter</button>
            </form>
        </div>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($appointments) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                        <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($row['patient_name']) ?></td>
                        <td><?= htmlspecialchars($row['reason']) ?></td>
                        <td>
                            <span id="status-<?= $row['id'] ?>" class="status-badge <?= strtolower(str_replace([' ', '-'], '', $row['status'])) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($row['status'] === 'Pending'): ?>
                                    <button class="btn-confirm" onclick="adminUpdateStatus(<?= $row['id'] ?>, 'Confirmed')">Confirm</button>
                                <?php endif; ?>
                                <?php if ($row['status'] !== 'Cancelled'): ?>
                                    <button class="btn-cancel" onclick="adminUpdateStatus(<?= $row['id'] ?>, 'Cancelled')">Cancel</button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:25px; color:#6c757d;">No appointments found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function adminUpdateStatus(id, status) {
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
            alert("Updated successfully");
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(() => alert("Something went wrong."));
}

</script>

</body>
</html>
