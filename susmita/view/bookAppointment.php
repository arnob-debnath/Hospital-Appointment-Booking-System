<!DOCTYPE html>
<html>

<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="../Assets/CSS/doctorProfile.css">
</head>

<body>

<div class="profile-container">

    <div class="profile-right" style="width:100%;">

        <h1>Book Appointment</h1>

        <?php if (!empty($error)) { ?>

            <p style="color:red; font-weight:bold; margin-bottom:15px;">
                <?php echo $error; ?>
            </p>

        <?php } ?>

        <form method="POST" action="../controller/bookAppointmentController.php">

            <input type="hidden" name="doctor_id"
            value="<?php echo $doctor_id; ?>">

            <input type="hidden" name="appointment_date"
            value="<?php echo $appointment_date; ?>">

            <input type="hidden" name="appointment_time"
            value="<?php echo $appointment_time; ?>">

            <p>
                <strong>Date:</strong>
                <?php echo $appointment_date; ?>
            </p>

            <p>
                <strong>Time:</strong>
                <?php echo $appointment_time; ?>
            </p>

            <label>
                Reason for appointment
            </label>

            <textarea
                name="reason"
                rows="5"
                style="width:100%; padding:15px; border-radius:15px; border:1px solid #cce7ea; margin-top:10px;">
            </textarea>

            <button type="submit" class="back-btn">
                Confirm Appointment
            </button>

        </form>

        <br>

        <a href="../controller/doctorProfileController.php?doctor_id=<?php echo $doctor_id; ?>" class="back-btn">
            Back
        </a>

    </div>

</div>

</body>

</html>