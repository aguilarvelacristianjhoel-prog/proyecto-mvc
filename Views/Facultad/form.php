<?php
$f = $data['fila'] ?? [];
$edit = isset($f['id']);

$titulo = $edit ? 'Editar facultad' : 'Nuevo facultad';

require ROOT_PATH . '/Views/Shared/head.php';
?>

<h2><?= e($titulo) ?></h2>

<?php foreach ($data['errores'] ?? [] as $error): ?>
    <p><?= e($error) ?></p>
<?php endforeach; ?>

<form method="post"
      action="<?= e(route($edit ? 'Facultad/actualizar' : 'Facultad/guardar')) ?>">

    <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">

    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= e($f['id']) ?>">
    <?php endif; ?>

    <p>
        <label>Nombre:</label><br>
        <input type="text" name="nombre" maxlength="120"
               value="<?= e($f['nombre'] ?? '') ?>" required>
    </p>

    <p>
        <label>Abreviatura:</label><br>
        <input type="text" name="abreviatura" maxlength="20"
               value="<?= e($f['abreviatura'] ?? '') ?>" required>
    </p>

    <button type="submit">Guardar</button>

    <a href="<?= e(route('Facultad')) ?>">Cancelar</a>
</form>

<?php
require ROOT_PATH . '/Views/Shared/foot.php';
?>
