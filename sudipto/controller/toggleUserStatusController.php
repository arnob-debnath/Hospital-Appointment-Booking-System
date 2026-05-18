<?php

session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access"
    ]);
    exit();
}

$user_id = $_POST["user_id"] ?? "";

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User id missing"
    ]);
    exit();
}

if ($user_id == $_SESSION["user_id"]) {
    echo json_encode([
        "success" => false,
        "message" => "You cannot deactivate yourself"
    ]);
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$userModel = new UserModel();

$userResult = $userModel->getUserById(
    $connection,
    "users",
    $user_id
);

if ($userResult->num_rows == 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit();
}

$user = $userResult->fetch_assoc();

if ($user["is_active"] == 1) {
    $new_status = 0;
} else {
    $new_status = 1;
}

$result = $userModel->toggleUserStatus(
    $connection,
    "users",
    $user_id,
    $new_status
);

if ($result) {
    echo json_encode([
        "success" => true,
        "new_status" => $new_status
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Status update failed"
    ]);
}

?>