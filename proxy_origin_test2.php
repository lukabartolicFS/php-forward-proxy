<?php

$request = "{$_SERVER['HTTP_REFERER']}/{$_SERVER['HTTP_ORIGIN']}/{$_SERVER['REMOTE_ADDR']}\n{$_SERVER['REQUEST_METHOD']} {$_SERVER['REQUEST_URI']} {$_SERVER['SERVER_PROTOCOL']}\r\n";

foreach (getallheaders() as $name => $value) {
    $request .= "$name: $value\r\n";
}
$request .= "\r\n" . file_get_contents('php://input');

$fp = file_put_contents('request2.log', $request, FILE_APPEND);

?>