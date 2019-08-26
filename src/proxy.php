<?php
require __DIR__ . '/../vendor/autoload.php';

use Proxy\Http\Request;
use Proxy\Proxy;

$config = include('config.php');
$origins = $config['origin_endpoints'];

$request = Request::createFromGlobals();
$proxy = new Proxy();

$proxy->getEventDispatcher()->addListener('request.sent', function($event) {
	if($event['response']->getStatusCode() != 200){
		die("Error");
	}
});
$proxy->getEventDispatcher()->addListener('request.complete', function($event) use($request) {
    $fp = file_put_contents('proxy.log', $request, FILE_APPEND);
});

foreach($origins as $origin) {
    $response = $proxy->forward($request, $origin);
    $response->send();
    $fp = file_put_contents('proxy.log', "Forwarded to: {$origin}\n", FILE_APPEND);
}

?>