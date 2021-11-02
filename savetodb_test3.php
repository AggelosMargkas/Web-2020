<?php


ob_start();

require_once 'vendor/autoload.php';


//exw perasei kai ton solsify kai ton json-streamer
//auton pou xrisimopoiw gia to foreach einai o json-streamer giati douleuei kalytera

use JsonMachine\JsonDecoder\ExtJsonDecoder;
use JsonMachine\JsonDecoder\Decoder;
use JsonStreamingParser\Listener;
use JsonStreamingParser\Listener\ListenerInterface;
use JsonStreamingParser\Test\Listener\TestListener;
use \JsonMachine\JsonMachine;

session_start();

$usernamee = 'testuser1';


$ipData = json_decode($_POST['Ips']);
$serverIpData_visited = json_decode($_POST['serverIp_visited']);

$FiltrarismenoData = $_POST['Filtrarismeno'];

file_put_contents('File.json', $FiltrarismenoData);

$fruits = JsonMachine::fromFile('File.json', '', new ExtJsonDecoder);

$conn = new PDO("mysql:host=localhost;dbname=web", 'root', '');

$con = mysqli_connect('localhost', 'root', '') or  die("Connect failed: %s\n" . $conn->error);


echo sizeof($serverIpData_visited);



foreach ($serverIpData_visited as $key => $value) {


    echo $value->serverLat_visited;
}

$stmt = $conn->prepare('insert into ipuserdata(username, ISP, serverIpUser, lat, lon) values(:username, :ISP, :serverIpUser, :lat, :lon)');


$stmt->bindValue('username', 'iii');
$stmt->bindValue('ISP', $ipData[0]);
$stmt->bindValue('serverIpUser', $ipData[1]);
$stmt->bindValue('lat', $ipData[2]);
$stmt->bindValue('lon', $ipData[3]);


$stmt->execute();


foreach ($serverIpData_visited as $key => $value) {


    $stmt = $conn->prepare('insert into ip_visited_test(username, server_Ip, latitude, longitude	) values(:username, :server_Ip, :server_latitude, :server_longitude)');


    $stmt->bindValue('username', 'Aggelos');
    $stmt->bindValue('server_Ip', $value->serverIp_visited);
    $stmt->bindValue('server_latitude', $value->serverLat_visited);
    $stmt->bindValue('server_longitude', $value->serverLon_visited);


    $stmt->execute();
}



/***************************************************************************************************************************************** */
/*************************************************      REQUEST ENTRY    **************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
foreach ($fruits as $entries => $value) {
    foreach ($value as $key => $whatever) {

        //Orizw null times gia thn entoli ths sql wste oti den exoume timi n apernietai san null.
        $help_expires =  null;
        $help_age =  null;
        $help_host = null;
        $help_lastModified =  null;
        $help_pragma =  null;
        $help_cacheControl =  null;
        $help_contentType =  null;

        $count = 0;


        for ($count = 0; $count < sizeof($whatever->Headers_request); $count++) {

            $stmt = $conn->prepare('insert into requestdata(REQ_username, REQ_method, REQ_url, REQ_timings,REQ_startedDateTime, REQ_serverIpAddress, REQ_isp, REQ_expires, REQ_age, REQ_host, REQ_lastModified, REQ_pragma, REQ_cacheControl, REQ_contentType) values(:username, :method, :url, :timings, :startedDateTime, :serverIpAddress, :ISP, :expires, :age, :host, :lastModified, :pragma, :cacheControl, :contentType)');

            //Orizw duo metavlites gia na pernw ta stoxeia ena ena tou kathe header.
            //edw bgazei warning giati merikes fores einai adeia
            $headerName = $whatever->Headers_request[$count]->name;
            $headerValue = $whatever->Headers_request[$count]->value;


            //elegxw gia to onoma tou kathe header kai pernw to periexomeno tou kathe fora.
            //Den vrika kati kalitero na kanw
            if (strcmp($headerName, 'Expires') == 0 || strcmp($headerName, 'expires') == 0) {
                $help_expires = $headerValue;
            } elseif (strcmp($headerName, 'Host') == 0 || strcmp($headerName, 'host') == 0) {
                $help_host = $headerValue;
            } elseif (strcmp($headerName, 'last-modified') == 0 || strcmp($headerName, 'Last-Modified') == 0) {
                $help_lastModified = $headerValue;
            } elseif (strcmp($headerName, 'Pragma') == 0 || strcmp($headerName, 'pragma') == 0) {
                $help_pragma = $headerValue;
            } elseif (strcmp($headerName, 'Cache-Control') == 0 || strcmp($headerName, 'cache-control') == 0) {
                $help_cacheControl = $headerValue;
            } elseif (strcmp($headerName, 'Content-Type') == 0 || strcmp($headerName, 'content-type') == 0) {
                $help_contentType = $headerValue;
            } elseif (strcmp($headerName, 'age') == 0 || strcmp($headerName, 'Age') == 0) {
                $help_age = $headerValue;
            }
            //end ths if kai pame na perasoume stin vasi 

        }

        $stmt->bindValue('username', $usernamee);
        $stmt->bindValue('method', $whatever->request->method);
        $stmt->bindValue('url', $whatever->request->url);
        $stmt->bindValue('timings', $whatever->timings->wait);
        $stmt->bindValue('startedDateTime', $whatever->startedDateTime->startedDateTime);
        $stmt->bindValue('serverIpAddress', $whatever->Ip->serverIPAddress);
        $stmt->bindValue('ISP', $ipData[0]);
        $stmt->bindValue('expires', $help_expires);
        $stmt->bindValue('age', $help_age);
        $stmt->bindValue('host', $help_host);
        $stmt->bindValue('lastModified', $help_lastModified);
        $stmt->bindValue('pragma', $help_pragma);
        $stmt->bindValue('cacheControl', $help_cacheControl);
        $stmt->bindValue('contentType', $help_contentType);


        $stmt->execute();
    }
}

/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */



/***************************************************************************************************************************************** */
/*************************************************      RESPONSE ENTRY    **************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
foreach ($fruits as $entries => $value) {
    foreach ($value as $key => $whatever) {

        //Orizw null times gia thn entoli ths sql wste oti den exoume timi n apernietai san null.
        $help_expires =  null;
        $help_age =  null;
        $help_host = null;
        $help_lastModified =  null;
        $help_pragma =  null;
        $help_cacheControl =  null;
        $help_contentType =  null;

        $count = 0;


        for ($count = 0; $count < sizeof($whatever->Headers_response); $count++) {

            $stmt = $conn->prepare('insert into responsedata(RES_username, RES_status, RES_statusText, RES_isp, RES_expires, RES_age, RES_host, RES_lastModified, RES_pragma, RES_cacheControl, RES_contentType) values(:username, :status, :statusText, :ISP,:expires, :age, :host, :lastModified, :pragma, :cacheControl, :contentType)');

            //Orizw duo metavlites gia na pernw ta stoxeia ena ena tou kathe header.
            //edw bgazei warning giati merikes fores einai adeia
            $headerName = $whatever->Headers_response[$count]->name;
            $headerValue = $whatever->Headers_response[$count]->value;


            //elegxw gia to onoma tou kathe header kai pernw to periexomeno tou kathe fora.
            //Den vrika kati kalitero na kanw
            if (strcmp($headerName, 'Expires') == 0 || strcmp($headerName, 'expires') == 0) {
                $help_expires = $headerValue;
            } elseif (strcmp($headerName, 'Host') == 0 || strcmp($headerName, 'host') == 0) {
                $help_host = $headerValue;
            } elseif (strcmp($headerName, 'last-modified') == 0 || strcmp($headerName, 'Last-Modified') == 0) {
                $help_lastModified = $headerValue;
            } elseif (strcmp($headerName, 'Pragma') == 0 || strcmp($headerName, 'pragma') == 0) {
                $help_pragma = $headerValue;
            } elseif (strcmp($headerName, 'Cache-Control') == 0 || strcmp($headerName, 'cache-control') == 0) {
                $help_cacheControl = $headerValue;
            } elseif (strcmp($headerName, 'Content-Type') == 0 || strcmp($headerName, 'content-type') == 0) {
                $help_contentType = $headerValue;
            } elseif (strcmp($headerName, 'age') == 0 || strcmp($headerName, 'Age') == 0) {
                $help_age = $headerValue;
            }
            //end ths if kai pame na perasoume stin vasi 

        }

        $stmt->bindValue('username', $usernamee);
        $stmt->bindValue('status', $whatever->response->status);
        $stmt->bindValue('statusText', $whatever->response->statusText);
        $stmt->bindValue('ISP', $ipData[0]);
        $stmt->bindValue('expires', $help_expires);
        $stmt->bindValue('age', $help_age);
        $stmt->bindValue('host', $help_host);
        $stmt->bindValue('lastModified', $help_lastModified);
        $stmt->bindValue('pragma', $help_pragma);
        $stmt->bindValue('cacheControl', $help_cacheControl);
        $stmt->bindValue('contentType', $help_contentType);


        $stmt->execute();
    }
}


header("Location: DataUpload.html");

ob_end_flush();

echo '<script type="text/javascript">alert("Upload succesful!");</script>';







/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
/***************************************************************************************************************************************** */
