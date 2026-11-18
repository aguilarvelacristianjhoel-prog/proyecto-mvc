<?php

// Carga automáticamente las clases ubicadas en Libraries/Core.
spl_autoload_register(function ($className) {
    $filePath = __DIR__ . '/' . $className . '.php';

    if (is_file($filePath)) {
        require_once $filePath;
    }
});
