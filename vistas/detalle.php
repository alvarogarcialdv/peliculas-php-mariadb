<dl>
    <dt>Director</dt><dd><?= escapar($pelicula['director']) ?></dd>
    <dt>Año</dt><dd><?= escapar($pelicula['anio']) ?></dd>
    <dt>Género</dt><dd><?= escapar($pelicula['genero']) ?></dd>
    <dt>Sinopsis</dt><dd class="sinopsis"><?= escapar($pelicula['sinopsis'] === '' ? 'Sin sinopsis.' : $pelicula['sinopsis']) ?></dd>
</dl>
<p><a class="boton" href="/peliculas/<?= escapar($pelicula['id']) ?>/editar">Editar película</a> <a href="/peliculas">Volver al listado</a></p>
<details>
    <summary>Eliminar película</summary>
    <p>¿Quieres eliminar «<?= escapar($pelicula['titulo']) ?>»? Esta acción no se puede deshacer.</p>
    <form method="post" action="/peliculas/<?= escapar($pelicula['id']) ?>/eliminar">
        <?php campoCsrf(); ?>
        <button class="peligro">Confirmar eliminación</button>
    </form>
</details>
