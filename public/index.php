<?php

use Quiz\Controllers\BaseController;

define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');
define('TEMPLATE_DIR', SOURCE_DIR . '/templates');

require_once SOURCE_DIR . '/bootstrap.php';

function run()
{
    $config = app(\Quiz\Core\Configuration::class);

    $requestUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $requestString = substr($requestUrl, strlen($config->get('baseUrl')));

    $urlParams = explode('/', $requestString);
    $controllerName = ucfirst(array_shift($urlParams));
    $controllerName = $config->get('controllerNamespace') .
        ($controllerName ? $controllerName : 'Index') . 'Controller';
    $actionName = strtolower(array_shift($urlParams));
    $actionName = ($actionName ? $actionName : 'index') . 'Action';

    /** @var BaseController $controller */
    $controller = app($controllerName);
    $controller->handleCall($actionName);
}

run();
