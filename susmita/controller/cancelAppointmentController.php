<?php

session_start();

header("Content-Type: application/json");

include "../../config/DatabaseConnection.php";
include "../model/AppointmentModel.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access"
    ]);
    exit();
}

$database = new DatabaseConnection();
$connection = $database->openConnection();

$appointmentModel = new AppointmentModel();

$patient_id = $_SESSION["user_id"];
$appointment_id = "";

if (isset($_POST["appointment_id"])) {
    $appointment_id = $_POST["appointment_id"];
}

if ($appointment_id == "") {
    echo json_encode([
        "success" => false,
        "message" => "Appointment ID missing"
    ]);
    exit();
}

$result = $appointmentModel->cancelAppointment(
    $connection,
    "appointments",
    $appointment_id,
    $patient_id
);

if ($result && $connection->affected_rows > 0) {
    echo json_encode([
        "success" => true,
        "message" => "Appointment cancelled successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Unable to cancel appointment"
    ]);
}

?>