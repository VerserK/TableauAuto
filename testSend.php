<?php
session_start ();

require_once 'connect.php';

    $empid = $_SESSION['empid'];
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
    $mailfromz = $_POST['mail_from'];

    foreach ($_POST['mail_mailto'] as $mailto){
            $mailto_value.= $mailto.",";
    }
    $mailto_value =  rtrim($mailto_value, ',');

    foreach ($_POST['mail_mailcc'] as $mailcc){
        $mailcc_value.= $mailcc.",";    
    }
    $mailcc_value =  rtrim($mailcc_value, ',');

    foreach ($_POST['mail_mailbcc'] as $mailbcc){
        $mailbcc_value.= $mailbcc.",";    
    }
    $mailbcc_value =  rtrim($mailbcc_value, ',');

    $mailsubject = $_POST['mail_subject'];

    $mailcontent=$_POST['summernotez'];
    
    class testmail {
        public $Enable = "";
        public $MailGroup = "";
        public $type = "";
        public $ID ="";
        public $ImageWidth = "";
        public $filterName= "";
        public $filterValue= "";
        public $imageName= "";
        public $CRON="";
        public $from="";
        public $to="";
        public $cc="";
        public $bcc="";
        public $Subject="";
        public $Content="";
    }
    $testmail = new testmail();
    $testmail->Enable = $mailEnablez;
    $testmail->MailGroup = $mailGroupz;
    $testmail->type = $mailtypez;
    $testmail->ID = $mailidz;
    $testmail->ImageWidth = $mailimagewidthz;
    $testmail->filterName = $mailfilternamez;
    $testmail->filterValue = $mailfiltervaluez;
    $testmail->imageName = $mailimagenamez;
    $testmail->CRON = $mailcornz;
    $testmail->from = $mailfromz;
    $testmail->to = $mailto_value;
    $testmail->cc = $mailcc_value;
    $testmail->bcc = $mailbcc_value;
    $testmail->Subject = $mailsubject;
    $testmail->Content = $mailcontent;

    $data = $testmail;
    // echo '<hr>';
    // echo json_encode($data,JSON_UNESCAPED_UNICODE);

    $json_data = json_encode($data, true);
    // // file_put_contents('myfile.json', $json_data);
    $associativeArray = json_decode($json_data, true);
    $queryString = http_build_query($associativeArray);
    $query = preg_replace('/\%5B\d+\%5D/', '', $queryString);
    echo $query;

    // create a new cURL resource
    $endpoint = 'https://tableau-function-test.azurewebsites.net/api/HttpTrigger1?';
    $url = $endpoint ."". $query;
    echo $url;
    $ch = curl_init();
        //set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // grab URL and pass it to the browser
    curl_exec($ch);

    // close cURL resource, and free up system resources
    curl_close($ch);
?>