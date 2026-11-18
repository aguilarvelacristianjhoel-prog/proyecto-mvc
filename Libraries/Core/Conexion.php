<?php

class Conexion
{
    private $conect;

    public function __construct()
    {
        try {
            $dsn = 'mysql:host=' . DB_HOST
                . ';port=' . DB_PORT
                . ';dbname=' . DB_NAME
                . ';charset=' . DB_CHARSET;

            $this->conect = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // No mostrar credenciales ni detalles internos al usuario final.
            error_log('Error de conexión a la base de datos: ' . $e->getMessage());
            throw new RuntimeException(
                'No se pudo conectar con la base de datos.'
            );
        }
    }

    public function connect()
    {
        return $this->conect;
    }
}
