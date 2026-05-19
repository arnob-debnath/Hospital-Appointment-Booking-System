<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json");

require_once __DIR__ . '/../model/AppointmentModel.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(["ok" => false, "message" => "Unauthorized access"]);
    exit();
}

$appointment_id = intval($_GET['id'] ?? 0);
$input = json_decode(file_get_contents("php://input"), true);
if (!is_array($input)) {
    $input = [];
}

$status = trim($input['status'] ?? "");
// Cancellation reason is intentionally not used because the main database has no cancellation_reason column.

if ($appointment_id <= 0 || empty($status)) {
    echo json_encode(["ok" => false, "message" => "Invalid request"]);
    exit();
}

$appointment = getAppointmentById($appointment_id);

if (!$appointment) {
    echo json_encode(["ok" => false, "message" => "Appointment not found"]);
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role === 'doctor') {
    $allowedStatuses = ['Completed', 'No-Show'];

    if (!in_array($status, $allowedStatuses)) {
        echo json_encode(["ok" => false, "message" => "Doctor can only mark Completed or No-Show"]);
        exit();
    }

    $doctor = getDoctorIdByUserId($user_id);

    if (!$doctor || $doctor['id'] != $appointment['doctor_id']) {
        echo json_encode(["ok" => false, "message" => "You can only update your own appointments"]);
        exit();
    }
}

if ($role === 'admin') {
    $allowedStatuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled', 'No-Show'];

    if (!in_array($status, $allowedStatuses)) {
        echo json_encode(["ok" => false, "message" => "Invalid status"]);
        exit();
    }

}

if ($role !== 'doctor' && $role !== 'admin') {
    echo json_encode(["ok" => false, "message" => "Permission denied"]);
    exit();
}

$updated = updateAppointmentStatus($appointment_id, $status);

if ($updated) {
    echo json_encode(["ok" => true, "new_status" => $status]);
} else {
    echo json_encode(["ok" => false, "message" => "Failed to update status"]);
}

?>
