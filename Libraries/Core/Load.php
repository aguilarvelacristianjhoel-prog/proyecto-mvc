<?php

$controllerFile = ROOT_PATH . '/Controllers/' . $controller . 'Controller.php';

if (is_file($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = $controller . 'Controller';
    $controllerObject = new $controllerClass();

    if (is_callable([$controllerObject, $method])) {
        $controllerObject->$method($params);
    } else {
        http_response_code(404);
        require_once ROOT_PATH . '/Controllers/ErrorController.php';
        (new ErrorController())->index();
    }
} else {
    http_response_code(404);
    require_once ROOT_PATH . '/Controllers/ErrorController.php';
    (new ErrorController())->index();
}
