<?php

session_start();

include("../../config/DatabaseConnection.php");
include("../model/UserModel.php");


$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$dob = $_POST["dob"] ?? "";
$blood_group = $_POST["blood_group"] ?? "";
$phone = trim($_POST["phone"] ?? "");


$hasError = false;




$_SESSION["name"] = $name;
$_SESSION["email"] = $email;
$_SESSION["dob"] = $dob;
$_SESSION["blood_group"] = $blood_group;
$_SESSION["phone"] = $phone;




/* ---------- Name Validation ---------- */

if (!$name) {

    $_SESSION["nameErr"] =
        "Name is required";

    $hasError = true;

} elseif (strlen($name) < 6) {

    $_SESSION["nameErr"] =
        "Name must be at least 6 characters";

    $hasError = true;

} elseif (
    preg_match('/[0-9]/', $name)
) {

    $_SESSION["nameErr"] =
        "Numbers are not allowed in name";

    $hasError = true;

} elseif (
    !preg_match('/^[a-zA-Z\s]+$/', $name)
) {

    $_SESSION["nameErr"] =
        "Special characters are not allowed";

    $hasError = true;

} else {

    unset($_SESSION["nameErr"]);
}


/* ---------- Email Validation ---------- */

if (!$email) {
    $_SESSION["emailErr"] = "Email is required";
    $hasError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["emailErr"] = "Invalid email format";
    $hasError = true;
} else {
    unset($_SESSION["emailErr"]);
    unset($_SESSION["emailExistsErr"]);
}




/* ---------- Password Validation ---------- */

if (!$password) {

    $_SESSION["passwordErr"] =
        "Password is required";

    $hasError = true;
} elseif (strlen($password) < 6) {

    $_SESSION["passwordErr"] =
        "Password must be at least 6 characters";

    $hasError = true;
} elseif (
    !preg_match('/[A-Z]/', $password)
) {

    $_SESSION["passwordErr"] =
        "Password must contain at least one uppercase letter";

    $hasError = true;
} elseif (
    !preg_match('/[a-z]/', $password)
) {

    $_SESSION["passwordErr"] =
        "Password must contain at least one lowercase letter";

    $hasError = true;
} elseif (
    !preg_match('/[0-9]/', $password)
) {

    $_SESSION["passwordErr"] =
        "Password must contain at least one number";

    $hasError = true;
} elseif (
    !preg_match('/[\W]/', $password)
) {

    $_SESSION["passwordErr"] =
        "Password must contain at least one special character";

    $hasError = true;
} else {

    unset($_SESSION["passwordErr"]);
}


/* ---------- DOB Validation ---------- */

if (!$dob) {
    $_SESSION["dobErr"] =
        "Date of birth is required";
    $hasError = true;
} else {
    unset($_SESSION["dobErr"]);
}


/* ---------- Blood Group Validation ---------- */

if (!$blood_group) {
    $_SESSION["bloodErr"] =
        "Blood group is required";
    $hasError = true;
} else {
    unset($_SESSION["bloodErr"]);
}


/* ---------- Phone Validation ---------- */

if (!$phone) {
    $_SESSION["phoneErr"] =
        "Phone number is required";
    $hasError = true;
} else {
    unset($_SESSION["phoneErr"]);
}


/* ---------- Error হলে Register Page ---------- */

if ($hasError) {

    header("Location: ../view/registration.php");
    exit();
}


/* ---------- Database Connection ---------- */

$db = new DatabaseConnection();
$connection = $db->openConnection();
$user = new UserModel();
$existingUser = $user->getUserByEmail(
    $connection,
    "users",
    $email
);

unset($_SESSION["emailExistsErr"]);

$existingUser = $user->getUserByEmail($connection, "users", $email);

if ($existingUser->num_rows > 0) {
    $_SESSION["emailExistsErr"] = "Email already exists!";
    header("Location: ../view/registration.php");
    exit();
}

/* ---------- Password Hash ---------- */

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/* ---------- Create Patient ---------- */

$result = $user->createPatient(
    $connection,
    "users",
    $name,
    $email,
    $password_hash,
    $dob,
    $blood_group,
    $phone
);




if ($result) {

    unset($_SESSION["name"]);
    unset($_SESSION["email"]);
    unset($_SESSION["dob"]);
    unset($_SESSION["blood_group"]);
    unset($_SESSION["phone"]);

    $_SESSION["successMsg"] =
        "Registration Successful! Please Login.";

    header("Location: ../view/login.php");
    exit();

} else {

    $_SESSION["registerErr"] =
        "Registration Failed!";

    header("Location: ../view/registration.php");
    exit();
}
