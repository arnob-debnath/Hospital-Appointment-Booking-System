<?php

session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SESSION["role"] != "patient") {
    header("Location: ../view/login.php");
    exit();
}

$action = $_POST["action"] ?? "";

$db = new DatabaseConnection();
$connection = $db->openConnection();

$userModel = new UserModel();

$userResult = $userModel->getUserById(
    $connection,
    "users",
    $_SESSION["user_id"]
);

$user = $userResult->fetch_assoc();


/* ---------- Update Profile ---------- */

if ($action == "update_profile") {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $dob = $_POST["dob"] ?? "";

    $hasError = false;

    if (!$name) {
        $_SESSION["profileNameErr"] = "Name is required";
        $hasError = true;
    } elseif (strlen($name) < 6) {
        $_SESSION["profileNameErr"] = "Name must be at least 6 characters";
        $hasError = true;
    } elseif (preg_match('/[0-9]/', $name)) {
        $_SESSION["profileNameErr"] = "Numbers are not allowed in name";
        $hasError = true;
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $_SESSION["profileNameErr"] = "Special characters are not allowed";
        $hasError = true;
    } else {
        unset($_SESSION["profileNameErr"]);
    }

    if (!$phone) {
        $_SESSION["profilePhoneErr"] = "Phone number is required";
        $hasError = true;
    } else {
        unset($_SESSION["profilePhoneErr"]);
    }

    if (!$dob) {
        $_SESSION["profileDobErr"] = "Date of birth is required";
        $hasError = true;
    } else {
        unset($_SESSION["profileDobErr"]);
    }

    if ($hasError) {
        header("Location: ../view/patientProfile.php");
        exit();
    }

    $result = $userModel->updateProfile(
        $connection,
        "users",
        $_SESSION["user_id"],
        $name,
        $phone,
        $dob
    );

    if ($result) {
        $_SESSION["name"] = $name;
        $_SESSION["profileSuccess"] = "Profile updated successfully";
    } else {
        $_SESSION["profileErr"] = "Profile update failed";
    }

    header("Location: ../view/patientProfile.php");
    exit();
}


/* ---------- Change Password ---------- */

if ($action == "change_password") {

    $current_password = trim($_POST["current_password"] ?? "");
    $new_password = trim($_POST["new_password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");

    $hasError = false;

    if (!$current_password) {
        $_SESSION["currentPasswordErr"] = "Current password is required";
        $hasError = true;
    } else {
        unset($_SESSION["currentPasswordErr"]);
    }

    if (!$new_password) {
        $_SESSION["newPasswordErr"] = "New password is required";
        $hasError = true;
    } elseif (strlen($new_password) < 6) {
        $_SESSION["newPasswordErr"] = "Password must be at least 6 characters";
        $hasError = true;
    } elseif (!preg_match('/[A-Z]/', $new_password)) {
        $_SESSION["newPasswordErr"] = "Password must contain one uppercase letter";
        $hasError = true;
    } elseif (!preg_match('/[a-z]/', $new_password)) {
        $_SESSION["newPasswordErr"] = "Password must contain one lowercase letter";
        $hasError = true;
    } elseif (!preg_match('/[0-9]/', $new_password)) {
        $_SESSION["newPasswordErr"] = "Password must contain one number";
        $hasError = true;
    } elseif (!preg_match('/[\W]/', $new_password)) {
        $_SESSION["newPasswordErr"] = "Password must contain one special character";
        $hasError = true;
    } else {
        unset($_SESSION["newPasswordErr"]);
    }

    if (!$confirm_password) {
        $_SESSION["confirmPasswordErr"] = "Confirm password is required";
        $hasError = true;
    } elseif ($new_password != $confirm_password) {
        $_SESSION["confirmPasswordErr"] = "Password does not match";
        $hasError = true;
    } else {
        unset($_SESSION["confirmPasswordErr"]);
    }

    if ($hasError) {
        header("Location: ../view/patientProfile.php");
        exit();
    }

    if (!password_verify($current_password, $user["password_hash"])) {
        $_SESSION["currentPasswordErr"] = "Current password is incorrect";
        header("Location: ../view/patientProfile.php");
        exit();
    }

    $new_password_hash = password_hash(
        $new_password,
        PASSWORD_DEFAULT
    );

    $result = $userModel->changePassword(
        $connection,
        "users",
        $_SESSION["user_id"],
        $new_password_hash
    );

    if ($result) {
        $_SESSION["profileSuccess"] = "Password changed successfully";
    } else {
        $_SESSION["profileErr"] = "Password change failed";
    }

    header("Location: ../view/patientProfile.php");
    exit();
}


$_SESSION["profileErr"] = "Invalid request";
header("Location: ../view/patientProfile.php");
exit();

?>