<?php
$titulo = 'Docentes';
require ROOT_PATH . '/Views/Shared/head.php';
?>

<h2>Docentes activos</h2>

<p>
    <a href="<?= e(route('Docente/crear')) ?>">
        Nuevo docente
    </a>
</p>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Facultad</th>
        <th>DNI</th>
        <th>Apellidos</th>
        <th>Nombres</th>
        <th>Correo</th>
        <th>Categoría</th>
        <th>Dedicación</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($data['filas'] as $f): ?>
        <tr>
            <td><?= e($f['facultad_nombre']) ?></td>
            <td><?= e($f['dni']) ?></td>
            <td><?= e($f['apellidos']) ?></td>
            <td><?= e($f['nombres']) ?></td>
            <td><?= e($f['correo']) ?></td>
            <td><?= e($f['categoria']) ?></td>
            <td><?= e($f['dedicacion']) ?></td>
            <td>
                <a href="<?= e(route('Docente/editar/' . $f['id'])) ?>">
                    Editar
                </a>

                <form method="post"
                      action="<?= e(route('Docente/eliminar')) ?>"
                      onsubmit="return confirm('¿Desactivar docente?')">

                    <input type="hidden" name="csrf"
                           value="<?= e(csrfToken()) ?>">

                    <input type="hidden" name="id"
                           value="<?= e($f['id']) ?>">

                    <button type="submit">Desactivar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php if (empty($data['filas'])): ?>
        <tr>
            <td colspan="8">No hay docentes activos.</td>
        </tr>
    <?php endif; ?>
</table>

<?php
require ROOT_PATH . '/Views/Shared/foot.php';
?>
