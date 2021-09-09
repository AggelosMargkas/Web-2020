<?php
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

$ipData = json_decode($_POST['Ips']);
$serverIpData_visited = json_decode($_POST['serverIp_visited']);

$FiltrarismenoData = $_POST['Filtrarismeno'];

file_put_contents('File.json', $FiltrarismenoData);

$fruits = JsonMachine::fromFile('File.json', '', new ExtJsonDecoder);

$conn = new PDO("mysql:host=localhost;dbname=webproject", 'root', '');

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


$usernamee = 'testuser1';

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


        for ($count = 0; $count < sizeof($whatever->Headers); $count++) {

            $stmt = $conn->prepare('insert into kefali3(username_bb, expiress, agee, hostt, lastModifiedd, pragmaa, cacheControll, contentTypee) values(:username, :expires, :age, :host, :lastModified, :pragma, :cacheControl, :contentType)');

            //Orizw duo metavlites gia na pernw ta stoxeia ena ena tou kathe header.
            //edw bgazei warning giati merikes fores einai adeia
            $headerName = $whatever->Headers[$count]->name;
            $headerValue = $whatever->Headers[$count]->value;


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


foreach ($fruits as $entries => $value) {
    foreach ($value as $key => $whatever) {
        $stmt = $conn->prepare('insert into datadokimastiko3(username_aa, stateTextt, serverIpAddresss, startedDateTimee, timingss, methodd, urll, statuss) values(:user, :stateText, :serverIpAddress, :startedDateTime, :timings, :method, :url, :status)');

        echo '<pre>', var_dump($whatever->Ip->serverIPAddress), '</pre>';


        $stmt->bindValue('user', $usernamee);
        $stmt->bindValue('stateText', $whatever->response->statusText);
        $stmt->bindValue('serverIpAddress', $whatever->Ip->serverIPAddress);
        $stmt->bindValue('startedDateTime', $whatever->startedDateTime->startedDateTime);
        $stmt->bindValue('timings', $whatever->timings->wait);
        $stmt->bindValue('method', $whatever->request->method);
        $stmt->bindValue('url', $whatever->request->url);
        $stmt->bindValue('status', $whatever->response->status);

        $stmt->execute();
    }
}
