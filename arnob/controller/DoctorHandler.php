<?php

include "../../config/DatabaseConnection.php";
include "../model/DoctorModel.php";
include "../model/SpecializationModel.php";


$action    = $_POST["action"] ?? "";
$uploadDir = "../View/uploads/";

$db         = new DatabaseConnection();
$connection = $db->openConnection();

$doctorModel = new DoctorModel();
$specializationModel = new SpecializationModel();

// Make sure uploads folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}


// ===================== FETCH ALL DOCTORS =====================

if ($action == "fetch") {


    $result = $doctorModel->getAllDoctors($connection);

    while ($row = $result->fetch_assoc()) {

        $photo = $row["photo_path"]
            ? "<img src='uploads/" . $row["photo_path"] . "' width='40' height='40' style='border-radius:50%;object-fit:cover'>"
            : "No photo";

        $status      = $row["is_active"] == 1 ? "Active" : "Inactive";
        $toggleLabel = $row["is_active"] == 1 ? "Deactivate" : "Reactivate";
        $days        = $row["available_days"] ? $row["available_days"] : "Not set";

        echo "
            <tr>
                <td>" . $photo . "</td>
                <td>" . $row["name"] . "<br><small>" . $row["email"] . "</small></td>
                <td>" . $row["specialization_name"] . "</td>
                <td>" . $row["consultation_fee"] . "</td>
                <td>" . $days . "</td>
                <td>" . $status . "</td>
                <td class='appt-count' data-id='" . $row["id"] . "'>0</td>
                <td>
                    <button type='button' onclick='openEditDoctor(" . $row["id"] . ")'>Edit</button>
                    <button type='button' onclick='toggleDoctor(" . $row["id"] . ", " . $row["is_active"] . ")'>" . $toggleLabel . "</button>
                </td>
            </tr>
        ";
    }
}


// ===================== FETCH SPECIALIZATIONS (for dropdown) =====================

if ($action == "fetchSpecializations") {

    $result  = $specializationModel->getAllSpecializations($connection);
    $options = "<option value=''>Select Specialization</option>";

    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }

    echo $options;
}


// ===================== FETCH SINGLE DOCTOR (for edit form) =====================

if ($action == "fetchOne") {

    $id  = $_POST["id"] ?? "";
    $row = $doctorModel->getDoctorById($connection, $id);

    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
}


// ===================== FETCH STATS =====================

if ($action == "fetchStats") {

    try {

        $result = $doctorModel->getDoctorStats($connection);
        $stats  = [];

        while ($row = $result->fetch_assoc()) {
            $stats[] = [
                "id"                => $row["id"],
                "name"              => $row["name"],
                "specialization"    => $row["specialization"],
                "appointment_count" => $row["appointment_count"]
            ];
        }

        echo json_encode($stats);

    } catch (Exception $e) {

        echo json_encode([]);
    }
}


// ===================== ADD DOCTOR =====================

if ($action == "add") {

    $name             = trim($_POST["name"]             ?? "");
    $email            = trim($_POST["email"]            ?? "");
    $password         = $_POST["password"]              ?? "";
    $specializationId = $_POST["specialization_id"]     ?? "";
    $bio              = trim($_POST["bio"]              ?? "");
    $fee              = $_POST["fee"]                   ?? 0;
    $days             = $_POST["available_days"]        ?? [];
    $availableDays    = implode(",", $days);

    if (!$name) {

        echo "Doctor name is required";

    } elseif (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "Valid email is required";

    } elseif ($doctorModel->checkEmailExists($connection, $email)) {

        echo "This email is already registered";

    } elseif (strlen($password) < 8) {

        echo "Password must be at least 8 characters";

    } elseif (!$specializationId) {

        echo "Specialization is required";

    } else {

        // Handle photo upload
        $photoPath = "";

        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {

            $allowed = ["image/jpeg", "image/jpg", "image/png"];

            if (!in_array($_FILES["photo"]["type"], $allowed)) {
                echo "Photo must be JPEG or PNG";
                exit;
            }

            if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) {
                echo "Photo must be under 2 MB";
                exit;
            }

            $ext       = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $photoPath = uniqid("doc_") . "." . strtolower($ext);

            move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadDir . $photoPath);
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $result = $doctorModel->insertDoctor(
            $connection,
            $name,
            $email,
            $passwordHash,
            $specializationId,
            $bio,
            $fee,
            $photoPath,
            $availableDays
        );

        if ($result) {
            echo "Doctor added successfully";
        } else {
            echo "Failed to add doctor";
        }
    }
}


// ===================== UPDATE DOCTOR =====================

if ($action == "update") {

    $doctorId         = $_POST["doctor_id"]         ?? "";
    $userId           = $_POST["user_id"]           ?? "";
    $name             = trim($_POST["name"]         ?? "");
    $email            = trim($_POST["email"]        ?? "");
    $password         = $_POST["password"]          ?? "";
    $specializationId = $_POST["specialization_id"] ?? "";
    $bio              = trim($_POST["bio"]          ?? "");
    $fee              = $_POST["fee"]               ?? 0;
    $days             = $_POST["available_days"]    ?? [];
    $availableDays    = implode(",", $days);

    if (!$doctorId || !$userId) {

        echo "ID is required";

    } elseif (!$name) {

        echo "Doctor name is required";

    } elseif (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "Valid email is required";

    } elseif ($doctorModel->checkEmailExists($connection, $email, $userId)) {

        echo "This email is already taken";

    } elseif ($password && strlen($password) < 8) {

        echo "New password must be at least 8 characters";

    } elseif (!$specializationId) {

        echo "Specialization is required";

    } else {

        // Handle photo upload
        $photoPath = "";

        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {

            $allowed = ["image/jpeg", "image/jpg", "image/png"];

            if (!in_array($_FILES["photo"]["type"], $allowed)) {
                echo "Photo must be JPEG or PNG";
                exit;
            }

            if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) {
                echo "Photo must be under 2 MB";
                exit;
            }

            $ext       = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $photoPath = uniqid("doc_") . "." . strtolower($ext);

            move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadDir . $photoPath);
        }

        $result = $doctorModel->updateDoctor(
            $connection,
            $doctorId,
            $userId,
            $name,
            $email,
            $specializationId,
            $bio,
            $fee,
            $availableDays,
            $photoPath
        );

        // Update password only if provided
        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $db->updateDoctorPassword($connection, $userId, $hash);
        }

        if ($result) {
            echo "Doctor updated successfully";
        } else {
            echo "Failed to update doctor";
        }
    }
}


// ===================== TOGGLE ACTIVE / INACTIVE =====================

if ($action == "toggleStatus") {

    $id       = $_POST["id"]        ?? "";
    $isActive = $_POST["is_active"] ?? "";

    $res    = $connection->query("SELECT user_id FROM doctors WHERE id = '$id'");
    $row    = $res->fetch_assoc();
    $userId = $row["user_id"] ?? "";

    if (!$userId) {

        echo "Doctor not found";

    } elseif ($isActive == 1) {

        $db->deactivateDoctor($connection, $userId);
        echo "Doctor deactivated";

    } else {

        $db->reactivateDoctor($connection, $userId);
        echo "Doctor reactivated";
    }
}

?>
