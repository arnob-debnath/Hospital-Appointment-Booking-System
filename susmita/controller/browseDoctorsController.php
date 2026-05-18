<?php

session_start();


if (
    !isset($_SESSION["user_id"])
    ||
    $_SESSION["role"] != "patient"
) {
    header("Location: ../../sudipto/view/login.php");
    exit();
}

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