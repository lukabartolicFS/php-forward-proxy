<?php
require __DIR__ . '/../vendor/autoload.php';

use Proxy\Http\Request;
use Proxy\Proxy;

$config = include('config.php');
$origins = $config['origin_endpoints'];
$headers = apache_request_headers();

$request = Request::createFromGlobals();
$proxy = new Proxy();

if ($headers['Authorization'] == $config['zoom_verification_token']) {
    $proxy->getEventDispatcher()->addListener('request.sent', function($event) {
        if($event['response']->getStatusCode() != 200){
            die("Error");
        }
    });
    $proxy->getEventDispatcher()->addListener('request.complete', function($event) use($request) {
        $fp = file_put_contents('proxy.log', date('Y-m-d H:i:s') . '\n' . $request, FILE_APPEND);
    });

    foreach($origins as $origin) {
        $response = $proxy->forward($request, $origin);
        $response->send();
    }
}
else {
    $fp = file_put_contents('proxy.log', date('Y-m-d H:i:s') . ' ' . 'Authorization failed' . '[' . $headers['Authorization'] . ']' . ' ' . $request, FILE_APPEND);
}

?>