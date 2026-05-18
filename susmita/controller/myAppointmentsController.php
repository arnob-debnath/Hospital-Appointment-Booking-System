<?php

session_start();

include "../../config/DatabaseConnection.php";
include "../model/AppointmentModel.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "patient") {
    header("Location: ../../sudipto/view/login.php");
    exit();
}

$database = new DatabaseConnection();
$connection = $database->openConnection();

$appointmentModel = new AppointmentModel();

$patient_id = $_SESSION["user_id"];

$appointments = $appointmentModel->getPatientAppointments(
    $connection,
    "appointments",
    "doctors",
    "users",
    "specializations",
    $patient_id
);

include "../view/myAppointments.php";

?>