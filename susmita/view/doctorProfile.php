<!DOCTYPE html>
<html>

<head>
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="../Assets/CSS/doctorProfile.css">
</head>

<body>

    <?php if (!isset($doctor) || $doctor == null) { ?>

        <div class="profile-container">
            <h2>Doctor Not Found</h2>

            <a href="../controller/browseDoctorsController.php" class="back-btn">
                Back to Doctors
            </a>
        </div>

    <?php } else { ?>

        <div class="profile-container">

            <div class="profile-left">

                <?php if (!empty($doctor['photo_path'])) { ?>

                    <img src="../<?php echo $doctor['photo_path']; ?>" class="doctor-img">

                <?php } else { ?>

                    <div class="no-image-large">
                        No Image
                    </div>

                <?php } ?>

                <h2>
                    <?php echo $doctor['doctor_name']; ?>
                </h2>

                <p class="specialization">
                    <?php echo $doctor['specialization_name']; ?>
                </p>

            </div>

            <div class="profile-right">

                <h1>Doctor Profile</h1>

                <p>
                    <strong>Email:</strong>
                    <?php echo $doctor['doctor_email']; ?>
                </p>

                <p>
                    <strong>Consultation Fee:</strong>
                    <?php echo number_format($doctor['consultation_fee'], 0); ?> Tk
                </p>

                <p>
                    <strong>Available Days:</strong>
                    <?php echo str_replace(",", ", ", $doctor['available_days']); ?>
                </p>

                <p>
                    <strong>Bio:</strong><br>
                    <?php echo $doctor['bio']; ?>
                </p>

                <div class="date-section">

                    <h2>Available Appointment Dates</h2>

                    <div class="date-buttons">

                        <?php
                        if (!empty($availableDates)) {
                            foreach ($availableDates as $availableDate) {
                                ?>

                                <button class="date-btn" data-date="<?php echo $availableDate['date']; ?>"
                                    data-doctor="<?php echo $doctor['doctor_id']; ?>">

                                    <?php echo $availableDate['day']; ?><br>
                                    <span>
                                        <?php echo $availableDate['show_date']; ?>
                                    </span>

                                </button>

                                <?php
                            }
                        } else {
                            echo "<p>No available dates found.</p>";
                        }
                        ?>

                    </div>

                </div>

                <div class="slot-section">

                    <h2>Available Time Slots</h2>

                    <div id="slotContainer" class="slot-container">
                        <p class="slot-message">
                            Please select a date to view available slots.
                        </p>
                    </div>

                </div>

                <a href="../controller/browseDoctorsController.php" class="back-btn">
                    Back to Doctors
                </a>

            </div>

        </div>

    <?php } ?>

    <script src="../Assets/JS/doctorSlot.js"></script>

</body>

</html>