<?php
declare(strict_types=1);

require __DIR__ . '/../src/validacion.php';
require __DIR__ . '/../src/presentacion.php';

function comprobar(bool $condicion, string $mensaje): void
{
    if (!$condicion) {
        throw new RuntimeException($mensaje);
    }
}

$base = ['titulo' => ' Película ', 'director' => ' Directora ', 'anio' => '2001', 'genero' => ' Drama ', 'sinopsis' => ''];
[$datos, $errores] = validarPelicula($base);
comprobar($errores === [], 'Debe admitir datos válidos y sinopsis vacía.');
comprobar($datos['titulo'] === 'Película' && $datos['genero'] === 'Drama', 'Debe eliminar espacios exteriores.');
foreach (['titulo' => 200, 'director' => 120, 'genero' => 80, 'sinopsis' => 2000] as $campo => $limite) {
    [, $errores] = validarPelicula(array_replace($base, [$campo => str_repeat('á', $limite)]));
    comprobar($errores === [], "Debe aceptar el límite Unicode de $campo.");
    [, $errores] = validarPelicula(array_replace($base, [$campo => str_repeat('á', $limite + 1)]));
    comprobar(isset($errores[$campo]), "Debe rechazar exceso en $campo.");
    [, $errores] = validarPelicula(array_replace($base, [$campo => []]));
    comprobar(isset($errores[$campo]), "Debe rechazar arrays en $campo.");
}
foreach (['titulo', 'director', 'genero'] as $campo) {
    [, $errores] = validarPelicula(array_replace($base, [$campo => '   ']));
    comprobar(isset($errores[$campo]), "Debe exigir $campo.");
}
foreach (['1887', (string) ((int) date('Y') + 2), '2000.5', '', 'abcd', []] as $anio) {
    [, $errores] = validarPelicula(array_replace($base, ['anio' => $anio]));
    comprobar(isset($errores['anio']), 'Debe rechazar años inválidos.');
}
foreach (['1888', (string) ((int) date('Y') + 1)] as $anio) {
    [, $errores] = validarPelicula(array_replace($base, ['anio' => $anio]));
    comprobar($errores === [], 'Debe aceptar los extremos del intervalo de años.');
}
comprobar(escapar('<script>"&') === '&lt;script&gt;&quot;&amp;', 'Debe escapar HTML.');
comprobar(urlEntrada() === '/index.php', 'La entrada pública debe estar centralizada.');
$url = urlRuta('/peliculas/7', ['busqueda' => 'A & B']);
comprobar($url === '/index.php?ruta=%2Fpeliculas%2F7&busqueda=A%20%26%20B', 'Debe codificar rutas y parámetros.');
comprobar(
    escapar($url) === '/index.php?ruta=%2Fpeliculas%2F7&amp;busqueda=A%20%26%20B',
    'Debe escapar las URL al insertarlas en HTML.'
);
echo "Validación y escape: correctos.\n";
