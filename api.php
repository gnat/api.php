<?php
/*
Easily build an Internet API in a single file using PHP (https://github.com/gnat/api.php)

Use with Curl
	curl -X POST 127.0.0.1/api.php -d '{"name":"Edward"}'
Use with Web Browser
	fetch('/api.php', {method: 'GET'}).then(async result => { console.log(`${(await result.json())}`) } )
*/

$input = [];
$output = [];
if(!empty(file_get_contents('php://input'))) { $input = json_decode(file_get_contents('php://input'), true); }
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET') {
	$output = ['time' => time()];
}
if($method == 'POST') {
	$name = $input['name'] ??= 'guest';
	$output = ['message' => "Hello, ".$name."!"];
}
if($method == 'PUT') {
	$output['error'] = "Not yet implemented";
	goto error;
}
if($method == 'DELETE') {
	$output['error'] = "Not yet implemented";
	goto error;
}

header('Content-Type: application/json');
echo json_encode($output);
exit();

error:

http_response_code(400);
header('Content-Type: application/json');
echo json_encode(["error" => ($output['error'] ? $output['error'] : "Bad request")]);
