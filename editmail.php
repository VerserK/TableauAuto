<?php
session_start ();

require_once 'connect.php';

$empid = $_SESSION['empid'];

if(isset($_POST['mail_enablez'])) {
    // Set "activation_status" to 1.
    $enableX = "x";
} else { 
    // Set "activation_status" to 0.
    $enableX = "";
}

//$enableX = $_POST['mail_enable'];

$mailgroup = $_POST['mail_mailgroupz'];

$mailtype = $_POST['mail_typez'];

$mailid = $_POST['mail_idz'];

$mailimagewidth = $_POST['mail_imagewidthz'];

$mailfiltername = $_POST['mail_filternamez'];

$mailfiltervalue = $_POST['mail_filtervaluez'];

$mailimagename = $_POST['mail_imagenamez'];

$mailcorn = $_POST['mail_cornz'];

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

$ip =  $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$session = session_id();
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$actiontype = 'update';

$sql = "UPDATE mailnoti SET 
                            [Enable] = ? ,
                            [MailGroup] = ? ,
                            [type] = ? ,
                            [ID] = ? ,
                            [ImageWidth] = ? ,
                            [filterName] = ? ,
                            [filterValue] = ? ,
                            [imageName] = ? ,
                            [CRON] = ?
                            WHERE [no] = '".$_GET['no']."' ";
$params = array($enableX,$mailgroup,$mailtype,$mailid,$mailimagewidth,$mailfiltername,$mailfiltervalue,$mailimagename,$mailcorn);

$sqleditallmail = "UPDATE mailnoti SET 
                            [from] = ? ,
                            [to] = ? ,
                            [cc] = ? ,
                            [bcc] = ? ,
                            [Subject] = ? ,
                            [Content] = ?
                            WHERE [MailGroup] = '".$mailgroup."' ";
$paramsallmail = array($mailfrom,$mailto_value,$mailcc_value,$mailbcc_value,$mailsubject,$mailcontent);

##Piep Array Mail to
$new_arr = array_map('trim', explode(',', $mailto_value));
foreach($new_arr as $newtext){
    $newtext_value.= "'".$newtext."',"; 
}
$cleanText = substr($newtext_value, 0, -1);
$sqlNewtext = "SELECT * FROM [dbo].[othermail] WHERE [mail] in ($cleanText) AND [MailGroup] = '".$mailgroup."' ";
$resultNewtext = sqlsrv_query($conn , $sqlNewtext);
// while ($row = sqlsrv_fetch_array($resultNewtext, SQLSRV_FETCH_ASSOC)){
//             $v = trim($row["mail"]);
//             $indexCompleted = array_search($v, $new_arr);
//             unset($new_arr[$indexCompleted]);
//         };
$clerSQL = "DELETE FROM othermail WHERE [no] = ? ";
$paramsclear = array($_GET['no']);
$stmtdelete = sqlsrv_query( $conn, $clerSQL, $paramsclear);
foreach($new_arr as $new_arr_r){
    if (strpos($new_arr_r,'@kubota.com') !== false){
                
    }else{
        if ($mailto_value === ''){

        }else{
            $saveMail = "INSERT INTO othermail ([mail],[no],[MailGroup],[created]) VALUES (?,'".$_GET['no']."',?,?)";
            $paramsMail = array($new_arr_r,$mailgroup,date("Y-m-d H:i:s"));
            $stmtmail = sqlsrv_query( $conn, $saveMail, $paramsMail);
        }
    }
}

##Piep Array Mail CC to
$new_mailcc_arr = array_map('trim', explode(',', $mailcc_value));
foreach($new_mailcc_arr as $new_mailcc_text){
    $new_mailcc_text_value.= "'".$new_mailcc_text."',"; 
}
$mailcc_cleanText = substr($new_mailcc_text_value, 0, -1);
$sqlNewmailcctext = "SELECT * FROM [dbo].[othermailCC] WHERE [mail] in ($mailcc_cleanText) AND [MailGroup] = '".$mailgroup."' ";
$resultNewmailcctext = sqlsrv_query($conn , $sqlNewmailcctext);
// while ($rowNewCC = sqlsrv_fetch_array($resultNewmailcctext, SQLSRV_FETCH_ASSOC)){
//             $vCC = trim($rowNewCC["mail"]);
//             $indexCompletedCC = array_search($vCC, $new_mailcc_arr);
//             unset($new_mailcc_arr[$indexCompletedCC]);
//         };
$clerSQLCC = "DELETE FROM othermailCC WHERE [no] = ? ";
$paramsclearCC = array($_GET['no']);
$stmtdeleteCC = sqlsrv_query( $conn, $clerSQLCC, $paramsclearCC);
foreach($new_mailcc_arr as $new_mailcc_arr_r){
    if (strpos($new_mailcc_arr_r,'@kubota.com') !== false){
                
    }else{
        if ($mailcc_value === ''){

        }else{
            $saveMailCC = "INSERT INTO othermailCC ([mail],[no],[MailGroup],[created]) VALUES (?,'".$_GET['no']."',?,?)";
            $paramsMailCC = array($new_mailcc_arr_r,$mailgroup,date("Y-m-d H:i:s"));
            $stmtmailCC = sqlsrv_query( $conn, $saveMailCC, $paramsMailCC);
        }
    }
}

##Piep Array Mail BCC to
$new_mailbcc_arr = array_map('trim', explode(',', $mailbcc_value));
foreach($new_mailbcc_arr as $new_mailbcc_text){
    $new_mailbcc_text_value.= "'".$new_mailbcc_text."',"; 
}
$mailbcc_cleanText = substr($new_mailbcc_text_value, 0, -1);
$sqlNewmailbcctext = "SELECT * FROM [dbo].[othermailBCC] WHERE [mail] in ($mailbcc_cleanText) AND [MailGroup] = '".$mailgroup."' ";
$resultNewmailbcctext = sqlsrv_query($conn , $sqlNewmailbcctext);
// while ($rowNewBCC = sqlsrv_fetch_array($resultNewmailbcctext, SQLSRV_FETCH_ASSOC)){
//             $vBCC = trim($rowNewCC["mail"]);
//             $indexCompletedCC = array_search($vBCC, $new_mailbcc_arr);
//             unset($new_mailbcc_arr[$indexCompletedBCC]);
//         };
$clerSQLBCC = "DELETE FROM othermailBCC WHERE [no] = ? ";
$paramsclearBCC = array($_GET['no']);
$stmtdeleteBCC = sqlsrv_query( $conn, $clerSQLBCC, $paramsclearBCC);
foreach($new_mailbcc_arr as $new_mailbcc_arr_r){
    if (strpos($new_mailbcc_arr_r,'@kubota.com') !== false){
                
    }else{
        if ($mailbcc_value === ''){

        }else{
            $saveMailBCC = "INSERT INTO othermailBCC ([mail],[no],[MailGroup],[created]) VALUES (?,'".$_GET['no']."',?,?)";
            $paramsMailBCC = array($new_mailbcc_arr_r,$mailgroup,date("Y-m-d H:i:s"));
            $stmtmailBCC = sqlsrv_query( $conn, $saveMailBCC, $paramsMailBCC);
        }
    }
}

$sqlselect = "SELECT * FROM mailnoti WHERE no = '".$_GET['no']."' ";
$queryselect = sqlsrv_query($conn , $sqlselect);
$resultselect = sqlsrv_fetch_array($queryselect, SQLSRV_FETCH_ASSOC);
$selectLOGS = $resultselect['no']." , ".$resultselect['Enable']." , ".$resultselect['MailGroup']." , ".$resultselect['type']." , ".$resultselect['ID']." , ".$resultselect['ImageWidth']." , ".$resultselect['filterName']." , ".$resultselect['filterValue']." , ".$resultselect['imageName']." , ".$resultselect['CRON']." , ".$resultselect['from']." , ".$resultselect['to']." , ".$resultselect['cc']." , ".$resultselect['bcc']." , ".$resultselect['Subject']." , ".$resultselect['Content']." , ".$resultselect['empid'];
$sqllogs = "INSERT INTO logs_users_action ([action],[ip],[agent],[session],[url],[action_type],[created],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$paramslogs = array($selectLOGS,$ip,$agent,$session,$url,$actiontype,date("Y-m-d H:i:s"),$empid);
$stmtlogs = sqlsrv_query($conn, $sqllogs, $paramslogs);

$stmt = sqlsrv_query( $conn, $sql, $params);
$stmtallmail = sqlsrv_query( $conn, $sqleditallmail, $paramsallmail);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}
else
{
    echo "<meta http-equiv='refresh' content='0;URL=dashboard' />";
        $message = "Record Update successfully";
    echo "<script type='text/javascript'>alert('$message');</script>";
    exit(0);
}
sqlsrv_close($conn);
?>