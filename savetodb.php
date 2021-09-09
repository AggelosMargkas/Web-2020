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


$FiltrarismenoData = $_POST['Filtrarismeno'];
$nameFile = $_POST['nameFile'];


//echo "$FiltrarismenoData";
//echo phpinfo();

//$temp = tmpfile();
//fwrite($temp, $FiltrarismenoData);

//echo "$temp";
//rewind($temp);

//$temp = tmpfile();
//fwrite($temp, $FiltrarismenoData);
//fseek($temp, 0);
//echo fread($temp, 2048);
$tempDir = tempnam(sys_get_temp_dir(), 'har');
echo $temp . "\n";


//echo "$myFile";
$testfile = '‪C:\Users\junio\Desktop\test.har';
$stream = fopen($testfile, 'r');

//fwrite($stream, $FiltrarismenoData);
/*
//echo "$FiltrarismenoData";
$listener = new \JsonStreamingParser\Listener\InMemoryListener();
try {
    $parser = new \JsonStreamingParser\Parser($stream, $listener);
    $parser->parse();
    fclose($stream);
} catch (Exception $e) {
    fclose($stream);
    throw $e;
}
*/

//var_dump($listener->getJson());

$fruits = JsonMachine::fromFile($stream, '', new ExtJsonDecoder);

$conn = new PDO("mysql:host=localhost;dbname=webproject", 'root', '');

$con = mysqli_connect('localhost', 'root', '') or  die("Connect failed: %s\n" . $conn->error);





//echo "$FiltrarismenoData";

//header('location:DataUpload.html');


//$fruits = JsonMachine::fromFile($testfile, '/entries/0/response');
$counter = 0;
//echo "$products";
foreach ($fruits as $entries => $value) {
    foreach ($value as $key => $whatever) {
        $stmt = $conn->prepare('insert into datadokimastiko(user, id, stateText, serverIpAddress, startedDateTime, timings, method, url, status) values(:user, :id, :stateText, :serverIpAddress, :startedDateTime, :timings, :method, :url, :status)');

        echo '<pre>', var_dump($whatever->Ip->serverIPAddress), '</pre>';
        $stmt->bindValue('user', 'RIma');

        $stmt->bindValue('id', 'Thauma Paidi');

        $stmt->bindValue('stateText', $whatever->response->statusText);
        $stmt->bindValue('serverIpAddress', $whatever->Ip->serverIPAddress);
        $stmt->bindValue('startedDateTime', $whatever->startedDateTime->startedDateTime);
        $stmt->bindValue('timings', $whatever->timings->wait);
        $stmt->bindValue('method', $whatever->request->method);
        $stmt->bindValue('url', $whatever->request->url);
        $stmt->bindValue('status', $whatever->response->status);

        $stmt->execute();
        $counter += 1;
    }
}
