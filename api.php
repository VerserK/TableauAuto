<?php 
 $url = 'http://localhost/am/test.php';
    $data = array("first_name" => "First name2","last_name" => "last name","email"=>"email@gmail.com","addresses" => array ("address1" => "some address" ,"city" => "city","country" => "CA", "first_name" =>  "Mother","last_name" =>  "Lastnameson","phone" => "555-1212", "province" => "ON", "zip" => "123 ABC" ) );
    $ch=curl_init($url);
    $data_string = json_encode($data);
    file_put_contents('myfile.json', $data_string);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, array("customer"=>$data_string));


    $result = curl_exec($ch);
    curl_close($ch);

    echo $result;
?>