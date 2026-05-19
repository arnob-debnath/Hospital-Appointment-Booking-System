<?php

require_once __DIR__ . '/../../config/DatabaseConnection.php';

$dbInstance = new DatabaseConnection();
$conn = $dbInstance->openConnection();

function getDoctorIdByUserId($user_id)
{
    global $conn;

    $sql = "SELECT id FROM doctors WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getTodayAppointments($doctor_user_id)
{
    global $conn;

    $sql = "SELECT
                a.id,
                a.appointment_date,
                a.appointment_time,
                a.reason,
                a.status,
                u.name AS patient_name
            FROM appointments a
            JOIN users u ON a.patient_id = u.id
            JOIN doctors d ON a.doctor_id = d.id
            WHERE d.user_id = ?
            AND a.appointment_date = CURDATE()
            ORDER BY a.appointment_time ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctor_user_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getWeeklyAppointments($doctor_user_id)
{
    global $conn;

    $sql = "SELECT
                a.id,
                a.appointment_date,
                a.appointment_time,
                a.reason,
                a.status,
                u.name AS patient_name
            FROM appointments a
            JOIN users u ON a.patient_id = u.id
            JOIN doctors d ON a.doctor_id = d.id
            WHERE d.user_id = ?
            AND a.appointment_date BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
                                       AND DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 4 DAY)
            ORDER BY a.appointment_date ASC, a.appointment_time ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctor_user_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getAllDoctors()
{
    global $conn;

    $sql = "SELECT d.id, u.name
            FROM doctors d
            JOIN users u ON d.user_id = u.id
            ORDER BY u.name ASC";

    return mysqli_query($conn, $sql);
}

function getAdminAppointments($doctor_id, $date, $status)
{
    global $conn;

    $sql = "SELECT
                a.id,
                a.appointment_date,
                a.appointment_time,
                a.reason,
                a.status,
                patient.name AS patient_name,
                doctor_user.name AS doctor_name
            FROM appointments a
            JOIN users patient ON a.patient_id = patient.id
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users doctor_user ON d.user_id = doctor_user.id
            WHERE 1";

    $types = "";
    $params = [];

    if (!empty($doctor_id)) {
        $sql .= " AND a.doctor_id = ?";
        $types .= "i";
        $params[] = $doctor_id;
    }

    if (!empty($date)) {
        $sql .= " AND a.appointment_date = ?";
        $types .= "s";
        $params[] = $date;
    }

    if (!empty($status)) {
        $sql .= " AND a.status = ?";
        $types .= "s";
        $params[] = $status;
    }

    $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Appointment query prepare failed: " . mysqli_error($conn));
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAppointmentById($appointment_id)
{
    global $conn;

    $sql = "SELECT * FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $appointment_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateAppointmentStatus($id, $status)
{
    global $conn;

    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Appointment status update prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    return mysqli_stmt_execute($stmt);
}

?>
