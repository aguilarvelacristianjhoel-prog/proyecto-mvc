<?php
$titulo = 'Inicio';
require ROOT_PATH . '/Views/Shared/head.php';
?>
    <h2>Inicio</h2>
    <p>Bienvenido al sistema de facultads y docentes.</p>
    <p>
        <a href="<?= e(route('Facultad')) ?>">Facultads</a>
    </p>
    <p>
        <a href="<?= e(route('Docente')) ?>">Docentes</a>
    </p>

<?php
require ROOT_PATH . '/Views/Shared/foot.php';
?>
