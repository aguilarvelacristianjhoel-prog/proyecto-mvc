<?php
$f = $data['fila'] ?? [];
$edit = isset($f['id']);

$titulo = $edit ? 'Editar docente' : 'Nuevo docente';

require ROOT_PATH . '/Views/Shared/head.php';
?>

<h2><?= e($titulo) ?></h2>

<?php foreach ($data['errores'] ?? [] as $error): ?>
    <p><?= e($error) ?></p>
<?php endforeach; ?>

<form method="post"
      action="<?= e(route($edit ? 'Docente/actualizar' : 'Docente/guardar')) ?>">

    <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">

    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= e($f['id']) ?>">
    <?php endif; ?>

    <p>
        <label>Facultad:</label><br>
        <select name="id_facultad" required>
            <option value="">Seleccionar facultad</option>

            <?php foreach ($data['facultads'] as $d): ?>
                <option value="<?= e($d['id']) ?>"
                    <?= (string)($f['id_facultad'] ?? '') === (string)$d['id'] ? 'selected' : '' ?>>
                    <?= e($d['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label>DNI:</label><br>
        <input type="text" name="dni"
               maxlength="8" pattern="[0-9]{8}"
               value="<?= e($f['dni'] ?? '') ?>" required>
    </p>

    <p>
        <label>Apellidos:</label><br>
        <input type="text" name="apellidos"
               maxlength="100"
               value="<?= e($f['apellidos'] ?? '') ?>" required>
    </p>

    <p>
        <label>Nombres:</label><br>
        <input type="text" name="nombres"
               maxlength="100"
               value="<?= e($f['nombres'] ?? '') ?>" required>
    </p>

    <p>
        <label>Correo:</label><br>
        <input type="email" name="correo"
               maxlength="150"
               value="<?= e($f['correo'] ?? '') ?>" required>
    </p>

    <p>
        <label>Categoría:</label><br>
        <select name="categoria" required>
            <option value="">Seleccionar categoria</option>

            <?php foreach ($data['categorias'] as $op): ?>
                <option value="<?= e($op) ?>"
                    <?= ($f['categoria'] ?? '') === $op ? 'selected' : '' ?>>
                    <?= e($op) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label>Dedicación:</label><br>
        <select name="dedicacion" required>
            <option value="">Seleccionar dedicacion</option>

            <?php foreach ($data['dedicaciones'] as $op): ?>
                <option value="<?= e($op) ?>"
                    <?= ($f['dedicacion'] ?? '') === $op ? 'selected' : '' ?>>
                    <?= e($op) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <button type="submit">Guardar</button>

    <a href="<?= e(route('Docente')) ?>">Cancelar</a>
</form>

<?php
require ROOT_PATH . '/Views/Shared/foot.php';
?>
