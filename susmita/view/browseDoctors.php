<!DOCTYPE html>
<html>
<head>
    <title>Browse Doctors</title>
    <link rel="stylesheet" href="../Assets/CSS/browseDoctors.css">
</head>
<body>

<h2 class="page-title">Browse Doctors</h2>
<p class="page-subtitle">Choose a specialist and book your appointment easily</p>

<div class="filter-box">
    <label>Filter by Specialization:</label>

    <select id="specialization_id">
        <option value="">All Specializations</option>

        <?php
        if ($specializations && $specializations->num_rows > 0) {
            while ($specialization = $specializations->fetch_assoc()) {
        ?>
                <option value="<?php echo $specialization['id']; ?>">
                    <?php echo $specialization['name']; ?>
                </option>
        <?php
            }
        }
        ?>
    </select>
</div>

<div id="doctorContainer" class="doctor-container">

<?php
if ($doctors && $doctors->num_rows > 0) {
    while ($doctor = $doctors->fetch_assoc()) {
?>

    <div class="doctor-card">

        <?php if (!empty($doctor['photo_path'])) { ?>
            <img src="../<?php echo $doctor['photo_path']; ?>">
        <?php } else { ?>
            <div class="no-image">No Image</div>
        <?php } ?>

        <h3><?php echo $doctor['doctor_name']; ?></h3>

        <p><strong>Specialization:</strong> <?php echo $doctor['specialization_name']; ?></p>

        <p><strong>Fee:</strong> <?php echo $doctor['consultation_fee']; ?> Tk</p>

        <p><strong>Available:</strong> <?php echo $doctor['available_days']; ?></p>

        <a class="profile-btn" href="../controller/doctorProfileController.php?doctor_id=<?php echo $doctor['doctor_id']; ?>">
            View Profile
        </a>

    </div>

<?php
    }
} else {
    echo "<p class='no-doctor'>No doctors found.</p>";
}
?>

</div>




<script src="../Assets/JS/doctorFilter.js"></script>

</body>
</html>