<?php

class SpecializationModel {

    function getAllSpecializations($connection) {
        $sql    = "SELECT * FROM specializations ORDER BY name";
        $result = $connection->query($sql);
        return $result;
    }

    function insertSpecialization($connection, $name) {
        $sql    = "INSERT INTO specializations (name) VALUES ('$name')";
        $result = $connection->query($sql);
        return $result;
    }

    function updateSpecialization($connection, $id, $name) {
        $sql    = "UPDATE specializations SET name = '$name' WHERE id = '$id'";
        $result = $connection->query($sql);
        return $result;
    }

    function deleteSpecialization($connection, $id) {
        // Block delete if doctors are assigned
        $check  = $connection->query("SELECT COUNT(*) as total FROM doctors WHERE specialization_id = '$id'");
        $row    = $check->fetch_assoc();

        if ($row["total"] > 0) {
            return "has_doctors";
        }

        $connection->query("DELETE FROM specializations WHERE id = '$id'");
        return "deleted";
    }

    function checkSpecializationNameExists($connection, $name, $excludeId = 0) {
        $sql    = "SELECT COUNT(*) as total FROM specializations WHERE name = '$name' AND id != '$excludeId'";
        $result = $connection->query($sql);
        $row    = $result->fetch_assoc();
        return $row["total"] > 0;
    }
}

?>
