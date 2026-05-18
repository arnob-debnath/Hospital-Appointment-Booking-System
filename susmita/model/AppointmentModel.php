<?php

class AppointmentModel
{
    function getBookedSlots($connection, $tableName, $doctor_id, $appointment_date)
    {
        $sql = "SELECT appointment_time 
                FROM $tableName
                WHERE doctor_id = '$doctor_id'
                AND appointment_date = '$appointment_date'
                AND status != 'Cancelled'";

        return $connection->query($sql);
    }


    function checkSlotBooked($connection, $tableName, $doctor_id, $appointment_date, $appointment_time)
    {
        $sql = "SELECT * FROM $tableName
                WHERE doctor_id = '$doctor_id'
                AND appointment_date = '$appointment_date'
                AND appointment_time = '$appointment_time'
                AND status != 'Cancelled'";

        return $connection->query($sql);
    }


    function bookAppointment($connection, $tableName, $patient_id, $doctor_id, $appointment_date, $appointment_time, $reason)
    {
        $sql = "INSERT INTO $tableName
                (patient_id, doctor_id, appointment_date, appointment_time, reason, status)
                VALUES
                ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time', '$reason', 'Pending')";

        return $connection->query($sql);
    }

    function getPatientAppointments($connection, $appointmentTable, $doctorTable, $userTable, $specializationTable, $patient_id)
    {
        $sql = "SELECT
                $appointmentTable.id AS appointment_id,
                $appointmentTable.appointment_date,
                $appointmentTable.appointment_time,
                $appointmentTable.reason,
                $appointmentTable.status,

                $userTable.name AS doctor_name,
                $specializationTable.name AS specialization_name

            FROM $appointmentTable

            INNER JOIN $doctorTable
            ON $appointmentTable.doctor_id = $doctorTable.id

            INNER JOIN $userTable
            ON $doctorTable.user_id = $userTable.id

            INNER JOIN $specializationTable
            ON $doctorTable.specialization_id = $specializationTable.id

            WHERE $appointmentTable.patient_id = '$patient_id'

            ORDER BY $appointmentTable.appointment_date DESC,
            $appointmentTable.appointment_time DESC";

        return $connection->query($sql);
    }


    function cancelAppointment($connection, $tableName, $appointment_id, $patient_id)
    {
        $sql = "UPDATE $tableName
            SET status = 'Cancelled'
            WHERE id = '$appointment_id'
            AND patient_id = '$patient_id'
            AND status = 'Pending'";

        return $connection->query($sql);
    }
}

?>