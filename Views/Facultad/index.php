<?php
$titulo = 'Facultads';
require ROOT_PATH . '/Views/Shared/head.php';
?>

<h2>Facultads activos</h2>

<p>
    <a href="<?= e(route('Facultad/crear')) ?>">
        Nuevo facultad
    </a>
</p>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Abreviatura</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($data['filas'] as $f): ?>
        <tr>
            <td><?= e($f['id']) ?></td>
            <td><?= e($f['nombre']) ?></td>
            <td><?= e($f['abreviatura']) ?></td>
            <td>
                <a href="<?= e(route('Facultad/editar/' . $f['id'])) ?>">
                    Editar
                </a>

                <form method="post"
                      action="<?= e(route('Facultad/eliminar')) ?>"
                      onsubmit="return confirm('¿Desactivar facultad?')">

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
            <td colspan="4">No hay facultads activos.</td>
        </tr>
    <?php endif; ?>
</table>

<?php
require ROOT_PATH . '/Views/Shared/foot.php';
?>
