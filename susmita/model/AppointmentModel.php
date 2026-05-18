<?php

class AppointmentModel
{
    function getBookedSlots($connection, $tableName, $doctor_id, $appointment_date)
    {
<<<<<<< HEAD
        $sql = "SELECT appointment_time
=======
        $sql = "SELECT appointment_time 
>>>>>>> fb04b10842d8f4b48238582cea08b09b7b13c23b
                FROM $tableName
                WHERE doctor_id = '$doctor_id'
                AND appointment_date = '$appointment_date'
                AND status != 'Cancelled'";

        return $connection->query($sql);
    }
<<<<<<< HEAD
=======


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
>>>>>>> fb04b10842d8f4b48238582cea08b09b7b13c23b
}

?>