<?php

session_start();

include "../../config/DatabaseConnection.php";
include "../model/DoctorModel.php";
include "../model/SpecializationModel.php";

$database =
new DatabaseConnection();

$connection =
$database->openConnection();

$doctorModel =
new DoctorModel();

$specializationModel =
new SpecializationModel();

$doctors =
$doctorModel->getAllDoctors(
    $connection,
    "doctors",
    "users",
    "specializations"
);

$specializations =
$specializationModel
->getAllSpecializations(
    $connection,
    "specializations"
);

include
"../view/browseDoctors.php";

?>