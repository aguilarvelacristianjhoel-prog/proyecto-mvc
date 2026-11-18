<?php

class Views
{
    public function render($controller, $view, $data = [])
    {
        $controllerName = str_replace('Controller', '', get_class($controller));
        $viewPath = ROOT_PATH . '/Views/' . $controllerName . '/' . $view . '.php';

        if (is_file($viewPath)) {
            require $viewPath;
            return;
        }

        http_response_code(404);
        require ROOT_PATH . '/Views/Error/error404.php';
    }
}
