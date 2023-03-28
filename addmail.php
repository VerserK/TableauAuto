<?php
session_start ();

require_once 'connect.php';

$empid = $_SESSION['empid'];

// if(isset($_POST['mail_enable'])) {
//     // Set "activation_status" to 1.
//     $enableX = "x";
// } else { 
//     // Set "activation_status" to 0.
//     $enableX = "";
// }
$sqlCheck = "SELECT *FROM [dbo].[allemployee] WHERE ISNULL([email],'') != '' ORDER BY eid";
$resultCheck = sqlsrv_query($conn, $sqlCheck);

    $mailRowz=$_POST['mail_rowz'];
    $mailEnablez=$_POST['mail_enablez'];
    $mailGroupz=$_POST['mail_mailgroupz'];
    $mailtypez = $_POST['mail_typez'];
    $mailidz = $_POST['mail_idz'];
    $mailimagewidthz = $_POST['mail_imagewidthz'];
    $mailfilternamez = $_POST['mail_filternamez'];
    $mailfiltervaluez = $_POST['mail_filtervaluez'];
    $mailimagenamez = $_POST['mail_imagenamez'];
    $mailcornz = $_POST['mail_cornz'];
    $mailfrom = $_POST['mail_from'];

    foreach ($_POST['mail_mailto'] as $mailto)
        $mailto_value.= $mailto.",";
    $mailto_value =  rtrim($mailto_value, ',');

    foreach ($_POST['mail_mailcc'] as $mailcc)
        $mailcc_value.= $mailcc.",";    
    $mailcc_value =  rtrim($mailcc_value, ',');
    
    foreach ($_POST['mail_mailbcc'] as $mailbcc)
        $mailbcc_value.= $mailbcc.",";    
    $mailbcc_value =  rtrim($mailbcc_value, ',');

    $mailsubject = $_POST['mail_subject'];

    $mailcontent=$_POST['summernotez'];
    foreach ($mailRowz as $key => $value){
        $save = "INSERT INTO mailnoti ([Enable],[MailGroup],[type],[ID],[ImageWidth],[filterName],[filterValue],[imageName],[CRON],[from],[to],[cc],[bcc],[Subject],[Content],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($mailEnablez[$key],$mailGroupz[$key],$mailtypez[$key],$mailidz[$key],$mailimagewidthz[$key],$mailfilternamez[$key],$mailfiltervaluez[$key],$mailimagenamez[$key],$mailcornz[$key],$mailfrom,$mailto_value,$mailcc_value,$mailbcc_value,$mailsubject,$mailcontent,$empid);
        $stmt = sqlsrv_query( $conn, $save, $params);
        
        $mailto_value_r = (explode(",",$mailto_value));
        foreach($mailto_value_r as $mailto_r){
            if (strpos($mailto_r,'@kubota.com') !== false){

            }else{
                $saveMail = "INSERT INTO othermail ([mail],[no],[MailGroup],[created]) VALUES (?,(SELECT MAX(no) FROM mailnoti),?,?)";
                $paramsMail = array($mailto_r,$mailGroupz[$key],date("Y-m-d H:i:s"));
                $stmtmail = sqlsrv_query( $conn, $saveMail, $paramsMail);
            }
        }

        $mailcc_value_r = (explode(",",$mailcc_value));
        foreach($mailcc_value_r as $mailcc_r){
            if (strpos($mailcc_r,'@kubota.com') !== false){
                
            }else{
                if ($mailcc_value === ''){

                }else{
                $saveMail = "INSERT INTO othermailCC ([mail],[no],[MailGroup],[created]) VALUES (?,(SELECT MAX(no) FROM mailnoti),?,?)";
                $paramsMail = array($mailcc_r,$mailGroupz[$key],date("Y-m-d H:i:s"));
                $stmtmail = sqlsrv_query( $conn, $saveMail, $paramsMail);
                }
            }
        }

        $mailbcc_value_r = (explode(",",$mailbcc_value));
        foreach($mailbcc_value_r as $mailbcc_r){
            if (strpos($mailbcc_r,'@kubota.com') !== false){
                
            }else{
                if ($mailbcc_value === ''){

                }else{
                $saveMail = "INSERT INTO othermailBCC ([mail],[no],[MailGroup],[created]) VALUES (?,(SELECT MAX(no) FROM mailnoti),?,?)";
                $paramsMail = array($mailbcc_r,$mailGroupz[$key],date("Y-m-d H:i:s"));
                $stmtmail = sqlsrv_query( $conn, $saveMail, $paramsMail);
                }
            }
        }
    }

$ip =  $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$session = session_id();
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$actiontype = 'submit';

$sql = "INSERT INTO mailnoti ([Enable],[MailGroup],[type],[ID],[ImageWidth],[filterName],[filterValue],[imageName],[CRON],[from],[to],[cc],[bcc],[Subject],[Content],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = array($enableX,$mailgroup,$mailtype,$mailid,$mailimagewidth,$mailfiltername,$mailfiltervalue,$mailimagename,$mailcorn,$mailfrom,$mailto_value,$mailcc_value,$mailbcc_value,$mailsubject,$mailcontent,$empid);

$sqlselect = "SELECT * FROM mailnoti WHERE no = (SELECT max(no) FROM mailnoti)";
$queryselect = sqlsrv_query($conn , $sqlselect);
$resultselect = sqlsrv_fetch_array($queryselect, SQLSRV_FETCH_ASSOC);
$selectLOGS = $resultselect['no']." , ".$resultselect['Enable']." , ".$resultselect['MailGroup']." , ".$resultselect['type']." , ".$resultselect['ID']." , ".$resultselect['ImageWidth']." , ".$resultselect['filterName']." , ".$resultselect['filterValue']." , ".$resultselect['imageName']." , ".$resultselect['CRON']." , ".$resultselect['from']." , ".$resultselect['to']." , ".$resultselect['cc']." , ".$resultselect['bcc']." , ".$resultselect['Subject']." , ".$resultselect['Content']." , ".$resultselect['empid'];
$sqllogs = "INSERT INTO logs_users_action ([action],[ip],[agent],[session],[url],[action_type],[created],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$paramslogs = array($selectLOGS,$ip,$agent,$session,$url,$actiontype,date("Y-m-d H:i:s"),$empid);
$stmtlogs = sqlsrv_query($conn, $sqllogs, $paramslogs);

//$stmt = sqlsrv_query( $conn, $sql, $params);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}
else
{
    echo "<meta http-equiv='refresh' content='0;URL=dashboard' />";
        $message = "Record add successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";
    exit(0);
}
sqlsrv_close($conn);
?>