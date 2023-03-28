<?php
    $serverName = "tableauauto.database.windows.net"; // update me
    $connectionOptions = array(
        "Database" => "tableauauto_db", // update me
        "Uid" => "boon", // update me
        "PWD" => "DEE@DA123", // update me
        "CharacterSet" => "UTF-8" // Char Set
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
?>