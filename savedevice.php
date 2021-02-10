<?php
$host = "localhost";
$username = "tamapiin_tam1993";
$password = "Tam260736";
$db = "tamapiin_coinmaster";
//$objConnect = mysqli_connect($host,$username,$password,$db);
if (isset($_POST["locale"])) {
    $header = array(apache_request_headers());
    $baerer = split(" ",$header[0]["Authorization"]);
    $token = $baerer[1];
    $deviceid = $_POST["Device"]["udid"];
    echo 'deviceToken -> '.$token;
    echo '<br/>deviceID ->'.$deviceid;

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://www.tamapi.info/cm/savedevice.php?deviceid='.$deviceid.'&devicetoken='.$token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    //$sql = "INSERT INTO devicetoken(DeviceID, DeviceToken) VALUES ('$deviceid','$token')";
    //mysqli_query($objConnect, $sql);
}else if(isset($_GET["deviceid"]) && isset($_GET["devicetoken"])){
    $deviceid = $_GET["deviceid"];
    $token = $_GET["devicetoken"];
    $sql = "INSERT INTO devicetoken(DeviceID, DeviceToken) VALUES ('$deviceid','$token')";
    //mysqli_query($objConnect, $sql);
    //echo $objConnect->error;
}else{
    echo "<br/>NoData";
}

?>