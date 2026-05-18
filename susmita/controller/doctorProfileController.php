<?php

session_start();

include "../../config/DatabaseConnection.php";
include "../model/DoctorModel.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$doctorModel = new DoctorModel();

$doctor_id = "";

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
}

$doctorResult = $doctorModel->getDoctorById(
    $connection,
    "doctors",
    "users",
    "specializations",
    $doctor_id
);

$doctor = null;
$availableDates = [];

if ($doctorResult && $doctorResult->num_rows > 0) {

    $doctor = $doctorResult->fetch_assoc();

    $availableDays = explode(",", $doctor['available_days']);

    $dateCount = 0;
    $dayPlus = 0;

    while ($dateCount < 7) {

        $date = date("Y-m-d", strtotime("+$dayPlus days"));
        $dayName = date("l", strtotime($date));

        if (in_array($dayName, $availableDays)) {

            $availableDates[] = [
                "date" => $date,
                "day" => $dayName,
                "show_date" => date("M d, Y", strtotime($date))
            ];

            $dateCount++;
        }

        $dayPlus++;
    }
}

include "../view/doctorProfile.php";

?>