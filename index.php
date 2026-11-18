<?php

require_once __DIR__ . '/Config/Config.php';
require_once __DIR__ . '/Libraries/Core/Helpers.php';

// Ruta por defecto: Home/index.
$url = trim($_GET['url'] ?? 'Home', '/');
$arrUrl = $url === '' ? ['Home'] : explode('/', $url);

$controller = ucfirst(preg_replace('/[^a-zA-Z0-9_]/', '', $arrUrl[0] ?? 'Home'));
$method = preg_replace('/[^a-zA-Z0-9_]/', '', $arrUrl[1] ?? 'index');
$params = '';

if (count($arrUrl) > 2) {
    $params = implode(',', array_map('urldecode', array_slice($arrUrl, 2)));
}

// Rutas absolutas para que el proyecto funcione aunque cambie el directorio actual.
define('ROOT_PATH', __DIR__);

require_once ROOT_PATH . '/Libraries/Core/Autoload.php';
require_once ROOT_PATH . '/Libraries/Core/Load.php';
