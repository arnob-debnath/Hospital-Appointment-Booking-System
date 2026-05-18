<!DOCTYPE html>
<html>

<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="../Assets/CSS/myAppointments.css">
</head>

<body>

<div class="appointment-page">

    <h1>My Appointments</h1>

    <p class="page-subtitle">
        View and manage your appointment history
    </p>

    <div id="messageBox"></div>

    <div class="appointment-container">

        <?php
        if ($appointments && $appointments->num_rows > 0) {

            while ($appointment = $appointments->fetch_assoc()) {
        ?>

            <div class="appointment-card" id="appointment-<?php echo $appointment['appointment_id']; ?>">

                <div class="appointment-header">

                    <div>
                        <h2>
                            <?php echo $appointment['doctor_name']; ?>
                        </h2>

                        <p>
                            <?php echo $appointment['specialization_name']; ?>
                        </p>
                    </div>

                    <span class="status-badge <?php echo strtolower($appointment['status']); ?>">
                        <?php echo $appointment['status']; ?>
                    </span>

                </div>

                <div class="appointment-info">

                    <p>
                        <strong>Date:</strong>
                        <?php echo $appointment['appointment_date']; ?>
                    </p>

                    <p>
                        <strong>Time:</strong>
                        <?php echo substr($appointment['appointment_time'], 0, 5); ?>
                    </p>

                    <p>
                        <strong>Reason:</strong>
                        <?php echo $appointment['reason']; ?>
                    </p>

                </div>

                <?php if ($appointment['status'] == "Pending") { ?>

                    <button
                        class="cancel-btn"
                        data-id="<?php echo $appointment['appointment_id']; ?>">
                        Cancel Appointment
                    </button>

                <?php } ?>

            </div>

        <?php
            }

        } else {
        ?>

            <div class="no-appointment">
                No appointments found.
            </div>

        <?php
        }
        ?>

    </div>

    <a href="../controller/browseDoctorsController.php" class="back-btn">
        Browse Doctors
    </a>

</div>

<script src="../Assets/JS/cancelAppointment.js"></script>

</body>

</html>