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
}

?>