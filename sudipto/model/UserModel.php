<?php

class UserModel
{

    function createPatient(
        $connection,
        $tableName,
        $name,
        $email,
        $password_hash,
        $dob,
        $blood_group,
        $phone
    ) {

        $role = "patient";
        $is_active = 1;

        $sql = "INSERT INTO $tableName
                (name, email, password_hash, role, dob, blood_group, phone, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param(
            "sssssssi",
            $name,
            $email,
            $password_hash,
            $role,
            $dob,
            $blood_group,
            $phone,
            $is_active
        );

        return $stmt->execute();
    }


    function getUserByEmail($connection, $tableName, $email)
    {
        $sql = "SELECT * FROM $tableName WHERE email = ?";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result();
    }


    function getUserById($connection, $tableName, $id)
    {
        $sql = "SELECT * FROM $tableName WHERE id = ?";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }


    function updateProfile(
        $connection,
        $tableName,
        $id,
        $name,
        $phone,
        $dob
    ) {

        $sql = "UPDATE $tableName
                SET name = ?, phone = ?, dob = ?
                WHERE id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $name,
            $phone,
            $dob,
            $id
        );

        return $stmt->execute();
    }


    function changePassword(
        $connection,
        $tableName,
        $id,
        $new_password_hash
    ) {

        $sql = "UPDATE $tableName
                SET password_hash = ?
                WHERE id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param(
            "si",
            $new_password_hash,
            $id
        );

        return $stmt->execute();
    }


    function getAllUsers($connection, $tableName)
    {
        $sql = "SELECT * FROM $tableName";
        return $connection->query($sql);
    }


    function toggleUserStatus(
        $connection,
        $tableName,
        $id,
        $new_status
    ) {

        $sql = "UPDATE $tableName
                SET is_active = ?
                WHERE id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param(
            "ii",
            $new_status,
            $id
        );

        return $stmt->execute();
    }
}

?>