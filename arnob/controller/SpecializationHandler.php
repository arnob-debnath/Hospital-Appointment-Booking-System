<?php


include "../../config/DatabaseConnection.php";
include "../model/DoctorModel.php";
include "../model/SpecializationModel.php";

$action = $_POST["action"] ?? "";

$db = new DatabaseConnection();
$connection = $db->openConnection();


// ===================== FETCH =====================

if ($action == "fetch") {
$specializationModel = new SpecializationModel();
    $result = $specializationModel->getAllSpecializations($connection);
    while ($row = $result->fetch_assoc()) {

        echo "
            <tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>
                    <button type='button' onclick='openEditSpecialization(" . $row["id"] . ", \"" . htmlspecialchars($row["name"], ENT_QUOTES) . "\")'>Edit</button>
                    <button type='button' onclick='deleteSpecialization(" . $row["id"] . ")'>Delete</button>
                </td>
            </tr>
        ";
    }
}


// ===================== ADD =====================

if ($action == "add") {

    $name = trim($_POST["name"] ?? "");

    if (!$name) {

        echo "Specialization name is required";

    } elseif (strlen($name) < 3) {

        echo "Name must be at least 3 characters";

    } elseif ($db->checkSpecializationNameExists($connection, $name)) {

        echo "This specialization already exists";

    } else {

        $result = $db->insertSpecialization($connection, $name);

        if ($result) {
            echo "Specialization added successfully";
        } else {
            echo "Failed to add specialization";
        }
    }
}


// ===================== UPDATE =====================

if ($action == "update") {

    $id   = $_POST["id"]   ?? "";
    $name = trim($_POST["name"] ?? "");

    if (!$id) {

        echo "ID is required";

    } elseif (!$name) {

        echo "Specialization name is required";

    } elseif (strlen($name) < 3) {

        echo "Name must be at least 3 characters";

    } elseif ($db->checkSpecializationNameExists($connection, $name, $id)) {

        echo "This specialization name already exists";

    } else {

        $result = $db->updateSpecialization($connection, $id, $name);

        if ($result) {
            echo "Specialization updated successfully";
        } else {
            echo "Failed to update";
        }
    }
}


// ===================== DELETE =====================

if ($action == "delete") {

    $id     = $_POST["id"] ?? "";
    $result = $db->deleteSpecialization($connection, $id);

    if ($result == "has_doctors") {
        echo "Cannot delete — doctors are assigned to this specialization";
    } else {
        echo "Specialization deleted successfully";
    }
}

?>
