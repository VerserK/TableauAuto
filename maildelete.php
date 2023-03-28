<?php
session_start ();
require_once 'connect.php';

$empid = $_SESSION['empid'];

$ip =  $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$session = session_id();
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$actiontype = 'dalete';

$sqldelete = "DELETE FROM [dbo].[mailnoti] WHERE [MailGroup] = ? ";
$params = array($_GET['MailGroup']);

$sqldeleteMail = "DELETE FROM [dbo].[othermail] WHERE [MailGroup] = ? ";
$paramsMail = array($_GET['MailGroup']);
$sqldeleteMailCC = "DELETE FROM [dbo].[othermailCC] WHERE [MailGroup] = ? ";
$paramsMailCC = array($_GET['MailGroup']);
$sqldeleteMailBCC = "DELETE FROM [dbo].[othermailBCC] WHERE [MailGroup] = ? ";
$paramsMailBCC = array($_GET['MailGroup']);

$sqlselect = "SELECT * FROM mailnoti WHERE MailGroup = '".$_GET['MailGroup']."' ";
$queryselect = sqlsrv_query($conn , $sqlselect);
$resultselect = sqlsrv_fetch_array($queryselect, SQLSRV_FETCH_ASSOC);
$selectLOGS = $resultselect['no']." , ".$resultselect['Enable']." , ".$resultselect['MailGroup']." , ".$resultselect['type']." , ".$resultselect['ID']." , ".$resultselect['ImageWidth']." , ".$resultselect['filterName']." , ".$resultselect['filterValue']." , ".$resultselect['imageName']." , ".$resultselect['CRON']." , ".$resultselect['from']." , ".$resultselect['to']." , ".$resultselect['cc']." , ".$resultselect['bcc']." , ".$resultselect['Subject']." , ".$resultselect['Content']." , ".$resultselect['empid'];
$sqllogs = "INSERT INTO logs_users_action ([action],[ip],[agent],[session],[url],[action_type],[created],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$paramslogs = array($selectLOGS,$ip,$agent,$session,$url,$actiontype,date("Y-m-d H:i:s"),$empid);
$stmtlogs = sqlsrv_query($conn, $sqllogs, $paramslogs);

$stmt = sqlsrv_query($conn,$sqldelete,$params);
$stmt = sqlsrv_query($conn,$sqldeleteMail,$paramsMail);
$stmt = sqlsrv_query($conn,$sqldeleteMailCC,$paramsMailCC);
$stmt = sqlsrv_query($conn,$sqldeleteMailBCC,$paramsMailBCC);
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