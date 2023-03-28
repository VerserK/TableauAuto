<?php
$serverName = "172.31.8.25"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"CRM Data", "UID"=>"boon", "PWD"=>"Boon@DA123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

?>