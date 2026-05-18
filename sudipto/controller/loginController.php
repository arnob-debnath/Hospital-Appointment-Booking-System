<?php

session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

$hasError = false;

/* ---------- Store Old Value ---------- */
$_SESSION["loginEmail"] = $email;

/* ---------- Email Validation ---------- */
if (!$email) {
    $_SESSION["loginEmailErr"] = "Email is required";
    $hasError = true;
} else {
    unset($_SESSION["loginEmailErr"]);
}

/* ---------- Password Validation ---------- */
if (!$password) {
    $_SESSION["loginPasswordErr"] = "Password is required";
    $hasError = true;
} else {
    unset($_SESSION["loginPasswordErr"]);
}

/* ---------- Error হলে Login Page ---------- */
if ($hasError) {
    header("Location: ../view/login.php");
    exit();
}

/* ---------- Database ---------- */
$db = new DatabaseConnection();
$connection = $db->openConnection();

$userModel = new UserModel();

$result = $userModel->getUserByEmail(
    $connection,
    "users",
    $email
);

if ($result->num_rows == 0) {
    $_SESSION["loginErr"] = "Invalid email or password";
    header("Location: ../view/login.php");
    exit();
}

$user = $result->fetch_assoc();

/* ---------- Active Check ---------- */
if ($user["is_active"] == 0) {
    $_SESSION["loginErr"] =
        "Your account has been deactivated. Contact admin.";
    header("Location: ../view/login.php");
    exit();
}

/* ---------- Password Verify ---------- */
if (!password_verify($password, $user["password_hash"])) {
    $_SESSION["loginErr"] = "Invalid email or password";
    header("Location: ../view/login.php");
    exit();
}

/* ---------- Login Success ---------- */
unset($_SESSION["loginEmail"]);
unset($_SESSION["loginEmailErr"]);
unset($_SESSION["loginPasswordErr"]);
unset($_SESSION["loginErr"]);

$_SESSION["user_id"] = $user["id"];
$_SESSION["name"] = $user["name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

/* ---------- Role Wise Redirect ---------- */
if ($user["role"] == "patient") {
    header("Location: ../view/patientHome.php");
    exit();
} elseif ($user["role"] == "doctor") {
    header("Location: ../../hasan/view/doctorHome.php");
    exit();
} elseif ($user["role"] == "admin") {
     header("Location: ../view/adminHome.php");
    exit();
} else {
    $_SESSION["loginErr"] = "Invalid user role";
    header("Location: ../view/login.php");
    exit();
}

?>