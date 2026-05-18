<?php

header("Content-Type: application/json");

include "../../config/DatabaseConnection.php";
include "../model/AppointmentModel.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$appointmentModel = new AppointmentModel();

$doctor_id = "";
$appointment_date = "";

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
}

if (isset($_GET['date'])) {
    $appointment_date = $_GET['date'];
}

$allSlots = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30"];

$bookedSlots = [];

$bookedResult = $appointmentModel->getBookedSlots(
    $connection,
    "appointments",
    $doctor_id,
    $appointment_date
);

if ($bookedResult && $bookedResult->num_rows > 0) {
    while ($row = $bookedResult->fetch_assoc()) {
        $bookedSlots[] = substr($row['appointment_time'], 0, 5);
    }
}

$availableSlots = [];

foreach ($allSlots as $slot) {
    if (!in_array($slot, $bookedSlots)) {
        $availableSlots[] = $slot;
    }
}

echo json_encode([
    "success" => true,
    "slots" => $availableSlots
]);

?>