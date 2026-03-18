<?php

namespace app;

use app\Containers\Container;
use Exception;
use Monolog\Level;

require_once __DIR__ . '/bootstrap.php';

try {
    $act = strtolower($_GET['act']);
    $method = $_GET['method'];

    $controller = Container::get('app\Controller\\' . ucfirst($act) . 'Controller');

    $requestBody = json_decode(file_get_contents('php://input'), true) ?: $_REQUEST;
    $result = $controller->$method($requestBody);

    if ($result) {
        echoJson($result);
    }
} catch (Exception $exception) {
    $message = $exception->getMessage();
    throwServerError($message);
    $logger->log(Level::Error, $message);
}