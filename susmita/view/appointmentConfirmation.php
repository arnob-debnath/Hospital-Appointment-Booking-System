<!DOCTYPE html>
<html>

<head>
    <title>Appointment Confirmation</title>
    <link rel="stylesheet" href="../Assets/CSS/doctorProfile.css">
</head>

<body>

    <div class="profile-container">

        <div class="profile-right" style="width:100%; text-align:center;">

            <h1>Appointment Booked Successfully</h1>

            <p>
                Your appointment request has been submitted.
            </p>

            <p>
                <strong>Appointment ID:</strong>
                <?php echo $appointment_id; ?>
            </p>

            <p>
                <strong>Doctor:</strong>
                <?php echo $doctor_name; ?>
            </p>

            <p>
                <strong>Date:</strong>
                <?php echo $appointment_date; ?>
            </p>

            <p>
                <strong>Time:</strong>
                <?php echo $appointment_time; ?>
            </p>

            <p>
                <strong>Status:</strong>
                Pending
            </p>

            <a href="../controller/browseDoctorsController.php" class="back-btn">
                Browse More Doctors
            </a>

            <a href="../controller/myAppointmentsController.php" class="back-btn">
                View My Appointments
            </a>

        </div>

    </div>

</body>

</html>