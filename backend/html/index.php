<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Src\Core\DatabaseConnector;

//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, X-Custom-Header");

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$dbConnector = new DatabaseConnector();
$requestMethod = $_SERVER["REQUEST_METHOD"];
$params = array();

$controller = "Src\QRBook\General\NotFoundController";

switch ($uri[1]) {
    case 'user':
        $controller = "Src\QRBook\User\UserController";
        break;
    case 'qr':
        $controller = "Src\QRBook\QRCode\QRCodeController";
        break;
    case 'link':
        $controller = "Src\QRBook\Link\LinkController";
        break;
    case 'stats':
        $controller = "Src\QRBook\Stats\StatsController";
        break;
    case 'comment':
        $controller = "Src\QRBook\Comment\CommentController";
        break;
    case 'image':
        $controller = "Src\QRBook\Image\ImageController";
        break;
}

(new $controller(
    $dbConnector,
    $_SERVER["REQUEST_METHOD"],
    $params
))->processRequest();
