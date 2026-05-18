<?php

header("Content-Type: application/json");

include "../../config/DatabaseConnection.php";
include "../model/DoctorModel.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$doctorModel = new DoctorModel();

$specialization_id = "";

if (isset($_GET['specialization_id'])) {
    $specialization_id = $_GET['specialization_id'];
}

if ($specialization_id == "") {
    $doctors = $doctorModel->getAllDoctors(
        $connection,
        "doctors",
        "users",
        "specializations"
    );
} else {
    $doctors = $doctorModel->getDoctorsBySpecialization(
        $connection,
        "doctors",
        "users",
        "specializations",
        $specialization_id
    );
}

$doctorList = [];

if ($doctors && $doctors->num_rows > 0) {
    while ($doctor = $doctors->fetch_assoc()) {
        $doctorList[] = $doctor;
    }
}

echo json_encode($doctorList);

?>