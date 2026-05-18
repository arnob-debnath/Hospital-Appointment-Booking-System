<?php

class DoctorModel {

    function getAllDoctors($connection) {
        $sql = "SELECT d.id, u.name, u.email, u.is_active,
                       s.name AS specialization_name,
                       d.specialization_id,
                       d.bio, d.consultation_fee,
                       d.photo_path, d.available_days
                FROM doctors d
                JOIN users u ON u.id = d.user_id
                JOIN specializations s ON s.id = d.specialization_id
                ORDER BY u.name";

        $result = $connection->query($sql);
        return $result;
    }

    function getDoctorById($connection, $id) {
        $sql = "SELECT d.id, u.id AS user_id, u.name, u.email, u.is_active,
                       d.specialization_id, d.bio,
                       d.consultation_fee, d.photo_path, d.available_days
                FROM doctors d
                JOIN users u ON u.id = d.user_id
                WHERE d.id = '$id'
                LIMIT 1";

        $result = $connection->query($sql);
        return $result->fetch_assoc();
    }

    function checkEmailExists($connection, $email, $excludeUserId = 0) {
        $sql    = "SELECT COUNT(*) as total FROM users WHERE email = '$email' AND id != '$excludeUserId'";
        $result = $connection->query($sql);
        $row    = $result->fetch_assoc();
        return $row["total"] > 0;
    }

    function insertDoctor($connection, $name, $email, $passwordHash, $specializationId, $bio, $fee, $photoPath, $availableDays) {
        // Step 1: Insert into users
        $sql1 = "INSERT INTO users (name, email, password_hash, role, is_active, must_reset_password, created_at)
                 VALUES ('$name', '$email', '$passwordHash', 'doctor', 1, 1, NOW())";

        if (!$connection->query($sql1)) {
            return false;
        }

        $userId = $connection->insert_id;

        // Step 2: Insert into doctors
        $sql2 = "INSERT INTO doctors (user_id, specialization_id, bio, consultation_fee, photo_path, available_days)
                 VALUES ('$userId', '$specializationId', '$bio', '$fee', '$photoPath', '$availableDays')";

        if (!$connection->query($sql2)) {
            return false;
        }

        return true;
    }

    function updateDoctor($connection, $doctorId, $userId, $name, $email, $specializationId, $bio, $fee, $availableDays, $photoPath = "") {
        // Update users
        $connection->query("UPDATE users SET name = '$name', email = '$email' WHERE id = '$userId'");

        // Update doctors
        $photoClause = $photoPath ? ", photo_path = '$photoPath'" : "";

        $sql = "UPDATE doctors
                SET specialization_id = '$specializationId',
                    bio               = '$bio',
                    consultation_fee  = '$fee',
                    available_days    = '$availableDays'
                    $photoClause
                WHERE id = '$doctorId'";

        return $connection->query($sql);
    }

    function updateDoctorPassword($connection, $userId, $passwordHash) {
        $sql = "UPDATE users SET password_hash = '$passwordHash' WHERE id = '$userId'";
        return $connection->query($sql);
    }

    function deactivateDoctor($connection, $userId) {
        $sql = "UPDATE users SET is_active = 0 WHERE id = '$userId'";
        return $connection->query($sql);
    }

    function reactivateDoctor($connection, $userId) {
        $sql = "UPDATE users SET is_active = 1 WHERE id = '$userId'";
        return $connection->query($sql);
    }

    function getDoctorStats($connection) {
        $sql = "SELECT d.id, u.name, s.name AS specialization,
                       COUNT(a.id) AS appointment_count
                FROM doctors d
                JOIN users u ON u.id = d.user_id
                JOIN specializations s ON s.id = d.specialization_id
                LEFT JOIN appointments a ON a.doctor_id = d.id
                GROUP BY d.id, u.name, s.name
                ORDER BY u.name";

        return $connection->query($sql);
    }
}

?>
