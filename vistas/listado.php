<form method="get" action="/peliculas" class="buscador">
    <label for="busqueda">Buscar por título</label>
    <input id="busqueda" name="busqueda" value="<?= escapar($busqueda) ?>">
    <button>Buscar</button>
    <a href="/peliculas">Ver todas</a>
</form>
<p><a class="boton" href="/peliculas/nueva">Nueva película</a></p>
<?php if ($peliculas === []): ?>
    <p><?= $busqueda === '' ? 'Todavía no hay películas. Añade la primera.' : 'No se han encontrado películas para esta búsqueda.' ?></p>
<?php else: ?>
    <div class="peliculas">
        <?php foreach ($peliculas as $pelicula): ?>
            <article>
                <h2><a href="/peliculas/<?= escapar($pelicula['id']) ?>"><?= escapar($pelicula['titulo']) ?></a></h2>
                <p><?= escapar($pelicula['director']) ?> · <?= escapar($pelicula['anio']) ?></p>
                <p><?= escapar($pelicula['genero']) ?></p>
                <a href="/peliculas/<?= escapar($pelicula['id']) ?>">Ver detalle</a>
                <a href="/peliculas/<?= escapar($pelicula['id']) ?>/editar">Editar</a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
