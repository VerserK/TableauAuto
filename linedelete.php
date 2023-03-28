<?php
session_start ();
require_once 'connect.php';

$empid = $_SESSION['empid'];

$ip =  $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$session = session_id();
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$actiontype = 'dalete';

$sqldelete = "DELETE FROM [dbo].[linenoti] WHERE [no] = ? ";
$params = array($_GET['no']);

$sqlselect = "SELECT * FROM linenoti WHERE no = '".$_GET['no']."' ";
$queryselect = sqlsrv_query($conn , $sqlselect);
$resultselect = sqlsrv_fetch_array($queryselect, SQLSRV_FETCH_ASSOC);
$selectLOGS = $resultselect['no']." , ".$resultselect['Dashboardname']." , ".$resultselect['ViewId']." , ".$resultselect['Token']." , ".$resultselect['FilterName']." , ".$resultselect['FilterValue']." , ".$resultselect['Time']." , ".$resultselect['Message']." , ".$resultselect['empid'];
$sqllogs = "INSERT INTO logs_users_action ([action],[ip],[agent],[session],[url],[action_type],[created],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$paramslogs = array($selectLOGS,$ip,$agent,$session,$url,$actiontype,date("Y-m-d H:i:s"),$empid);
$stmtlogs = sqlsrv_query($conn, $sqllogs, $paramslogs);

$stmt = sqlsrv_query($conn,$sqldelete,$params);

if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}
else
{
    echo "<meta http-equiv='refresh' content='0;URL=dashboard' />";
        $message = "Record Delete successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";
    exit(0);
}
sqlsrv_close($conn);
?>