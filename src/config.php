<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

return [
    'origin_endpoints' => [
        'http://localhost/acacia_zoom_proxy/proxy_origin_test.php',
        'http://localhost/acacia_zoom_proxy/proxy_origin_test2.php'
    ],
    'zoom_verification_token' => getenv('ZOOM_VERIFICATION_TOKEN')
]
?>