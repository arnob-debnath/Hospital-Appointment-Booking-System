<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../sudipto/view/login.php");
    exit();
}

require_once __DIR__ . '/../model/AppointmentModel.php';

$doctor_id = $_GET['doctor_id'] ?? "";
$date = $_GET['date'] ?? "";
$status = $_GET['status'] ?? "";

$doctors = getAllDoctors();
$appointments = getAdminAppointments($doctor_id, $date, $status);

?>
