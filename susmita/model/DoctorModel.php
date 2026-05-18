<?php

class DoctorModel
{
    function getAllDoctors(
        $connection,
        $doctorTable,
        $userTable,
        $specializationTable
    )
    {
        $sql = "SELECT
                    $doctorTable.id AS doctor_id,
                    $userTable.name AS doctor_name,
                    $specializationTable.name AS specialization_name,
                    $doctorTable.consultation_fee,
                    $doctorTable.photo_path,
                    $doctorTable.available_days

                FROM $doctorTable

                INNER JOIN $userTable
                ON $doctorTable.user_id = $userTable.id

                INNER JOIN $specializationTable
                ON $doctorTable.specialization_id =
                $specializationTable.id

                WHERE $userTable.role='doctor'
                AND $userTable.is_active=1";

        return $connection->query($sql);
    }


    function getDoctorsBySpecialization(
        $connection,
        $doctorTable,
        $userTable,
        $specializationTable,
        $specialization_id
    )
    {
        $sql = "SELECT
                    $doctorTable.id AS doctor_id,
                    $userTable.name AS doctor_name,
                    $specializationTable.name AS specialization_name,
                    $doctorTable.consultation_fee,
                    $doctorTable.photo_path,
                    $doctorTable.available_days

                FROM $doctorTable

                INNER JOIN $userTable
                ON $doctorTable.user_id = $userTable.id

                INNER JOIN $specializationTable
                ON $doctorTable.specialization_id =
                $specializationTable.id

                WHERE $userTable.role='doctor'
                AND $userTable.is_active=1
                AND $doctorTable.specialization_id =
                '$specialization_id'";

        return $connection->query($sql);
    }

    function getDoctorById(
    $connection,
    $doctorTable,
    $userTable,
    $specializationTable,
    $doctor_id
)
{
    $sql = "SELECT
                $doctorTable.id AS doctor_id,
                $userTable.name AS doctor_name,
                $userTable.email AS doctor_email,
                $specializationTable.name AS specialization_name,
                $doctorTable.bio,
                $doctorTable.consultation_fee,
                $doctorTable.photo_path,
                $doctorTable.available_days

            FROM $doctorTable

            INNER JOIN $userTable
            ON $doctorTable.user_id = $userTable.id

            INNER JOIN $specializationTable
            ON $doctorTable.specialization_id = $specializationTable.id

            WHERE $doctorTable.id = '$doctor_id'
            AND $userTable.role = 'doctor'
            AND $userTable.is_active = 1";

    return $connection->query($sql);
}
}

?>