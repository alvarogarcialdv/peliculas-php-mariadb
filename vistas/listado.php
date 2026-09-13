<form method="get" action="<?= escapar(urlEntrada()) ?>" class="buscador">
    <input type="hidden" name="ruta" value="/peliculas">
    <label for="busqueda">Buscar por título</label>
    <input id="busqueda" name="busqueda" value="<?= escapar($busqueda) ?>">
    <button>Buscar</button>
    <a href="<?= escapar(urlRuta('/peliculas')) ?>">Ver todas</a>
</form>
<p><a class="boton" href="<?= escapar(urlRuta('/peliculas/nueva')) ?>">Nueva película</a></p>
<?php if ($peliculas === []): ?>
    <p><?= $busqueda === '' ? 'Todavía no hay películas. Añade la primera.' : 'No se han encontrado películas para esta búsqueda.' ?></p>
<?php else: ?>
    <div class="peliculas">
        <?php foreach ($peliculas as $pelicula): ?>
            <article>
                <h2><a href="<?= escapar(urlRuta('/peliculas/' . $pelicula['id'])) ?>"><?= escapar($pelicula['titulo']) ?></a></h2>
                <p><?= escapar($pelicula['director']) ?> · <?= escapar($pelicula['anio']) ?></p>
                <p><?= escapar($pelicula['genero']) ?></p>
                <a href="<?= escapar(urlRuta('/peliculas/' . $pelicula['id'])) ?>">Ver detalle</a>
                <a href="<?= escapar(urlRuta('/peliculas/' . $pelicula['id'] . '/editar')) ?>">Editar</a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
