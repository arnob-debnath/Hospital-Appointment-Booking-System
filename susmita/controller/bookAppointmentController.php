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

$doctor_id = "";
$appointment_date = "";
$appointment_time = "";

$error = "";
$appointment_id = "";

$patient_id = $_SESSION["user_id"];

if (isset($_GET["doctor_id"])) {
    $doctor_id = $_GET["doctor_id"];
}

if (isset($_GET["date"])) {
    $appointment_date = $_GET["date"];
}

if (isset($_GET["time"])) {
    $appointment_time = $_GET["time"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST["doctor_id"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
    $reason = trim($_POST["reason"]);

    if (empty($reason)) {

        $error = "Reason is required";

    } else {

        $slotCheck = $appointmentModel->checkSlotBooked(
            $connection,
            "appointments",
            $doctor_id,
            $appointment_date,
            $appointment_time
        );

        if ($slotCheck && $slotCheck->num_rows > 0) {

            $error = "Sorry, this slot is already booked.";

        } else {

            $result = $appointmentModel->bookAppointment(
                $connection,
                "appointments",
                $patient_id,
                $doctor_id,
                $appointment_date,
                $appointment_time,
                $reason
            );

            if ($result) {

                $appointment_id = $connection->insert_id;

                include "../view/appointmentConfirmation.php";
                exit();

            } else {

                $error = "Appointment booking failed.";
            }
        }
    }
}

include "../view/bookAppointment.php";

?>