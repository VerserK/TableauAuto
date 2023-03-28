<?php
session_start ();

require_once 'connect.php';

$empid = $_SESSION['empid'];

$linename = $_POST['line_name'];

$lineviewid = $_POST['line_viewid'];

$linetoken = $_POST['line_token'];

$linefiltername = $_POST['line_filtername'];

$linefiltervalue = $_POST['line_filtervalue'];

$linecorn = $_POST['line_corn'];

$linemessage = $_POST['line_message'];

class testline {
    public $DashboardName = "";
    public $ViewId = "";
    public $Token = "";
    public $FilterName = "";
    public $FilterValue = "";
    public $Time = "";
    Public $Message = "";
}
$testline = new  testline();
$testline->DashboardName = $linename;
$testline->ViewId = $lineviewid;
$testline->Token = $linetoken;
$testline->FilterName = $linefiltername;
$testline->FilterValue = $linefiltervalue;
$testline->Time = $linecorn;
$testline->Message = $linemessage;
$data = $testline;
$json_data = json_encode($data, true);
$associativeArray = json_decode($json_data, true);
$queryString = http_build_query($associativeArray);
// echo $queryString;
$endpoint = 'https://tableau-function-test.azurewebsites.net/api/HttpTrigger2?';
$url = $endpoint ."". $queryString;
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