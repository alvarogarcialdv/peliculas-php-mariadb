<form method="post" action="<?= escapar($accion) ?>" class="formulario">
    <?php campoCsrf(); ?>
    <?php foreach (['titulo' => 'Título', 'director' => 'Director', 'anio' => 'Año', 'genero' => 'Género', 'sinopsis' => 'Sinopsis (opcional)'] as $campo => $etiqueta): ?>
        <div>
            <label for="<?= $campo ?>"><?= $etiqueta ?></label>
            <?php if ($campo === 'sinopsis'): ?>
                <textarea id="sinopsis" name="sinopsis" rows="5" maxlength="2000" <?= isset($errores[$campo]) ? 'aria-invalid="true" aria-describedby="error-sinopsis"' : '' ?>><?= escapar($pelicula[$campo] ?? '') ?></textarea>
            <?php else: ?>
                <input id="<?= $campo ?>" name="<?= $campo ?>" value="<?= escapar($pelicula[$campo] ?? '') ?>" required
                    <?= $campo === 'anio' ? 'type="number" min="1888" max="' . ((int) date('Y') + 1) . '" step="1"' : 'type="text" maxlength="' . ['titulo' => 200, 'director' => 120, 'genero' => 80][$campo] . '"' ?>
                    <?= isset($errores[$campo]) ? 'aria-invalid="true" aria-describedby="error-' . $campo . '"' : '' ?>>
            <?php endif; ?>
            <?php if (isset($errores[$campo])): ?>
                <p class="error" id="error-<?= $campo ?>"><?= escapar($errores[$campo]) ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button>Guardar película</button>
    <a href="/peliculas">Cancelar</a>
</form>
