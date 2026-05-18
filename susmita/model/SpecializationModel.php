<?php

class SpecializationModel
{
    function getAllSpecializations(
        $connection,
        $tableName
    )
    {
        $sql =
        "SELECT * FROM $tableName";

        return $connection->query($sql);
    }
}

?>