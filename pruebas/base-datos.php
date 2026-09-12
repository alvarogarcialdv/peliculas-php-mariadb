<?php
declare(strict_types=1);

require __DIR__ . '/../src/conexion.php';
require __DIR__ . '/../src/peliculas.php';

// Ejecutar contra una base de pruebas con esquema.sql importado.
$bd = conexion();
$bd->beginTransaction();
try {
    $marca = 'Prueba-' . bin2hex(random_bytes(8));
    $datos = ['titulo' => $marca . '%_!', 'director' => 'Directora', 'anio' => '2001', 'genero' => 'Drama', 'sinopsis' => 'Prueba'];
    $id = guardarPelicula($bd, $datos);
    if (obtenerPelicula($bd, $id)['titulo'] !== $datos['titulo']) {
        throw new RuntimeException('Fallo al crear o consultar.');
    }
    $datosSinSinopsis = $datos;
    $datosSinSinopsis['titulo'] = $marca . ' sin sinopsis';
    $datosSinSinopsis['sinopsis'] = '';
    $idSinSinopsis = guardarPelicula($bd, $datosSinSinopsis);
    if (obtenerPelicula($bd, $idSinSinopsis)['sinopsis'] !== '') {
        throw new RuntimeException('La sinopsis vacía debe conservarse como cadena vacía.');
    }
    $resultados = listarPeliculas($bd, strtolower($datos['titulo']));
    if (count($resultados) !== 1 || (string) $resultados[0]['id'] !== $id) {
        throw new RuntimeException('Fallo en búsqueda sin mayúsculas o con comodines literales.');
    }
    $datos['anio'] = '1999';
    $segundo = guardarPelicula($bd, $datos);
    $resultados = listarPeliculas($bd, $marca);
    $mismoTitulo = array_values(array_filter(
        $resultados,
        static fn (array $pelicula): bool => $pelicula['titulo'] === $datos['titulo']
    ));
    if (count($mismoTitulo) !== 2 || (string) $mismoTitulo[0]['id'] !== $segundo) {
        throw new RuntimeException('Fallo en ordenación por año.');
    }
    $datos['titulo'] = $marca . ' editada';
    guardarPelicula($bd, $datos, $id);
    if (obtenerPelicula($bd, $id)['titulo'] !== $datos['titulo']) {
        throw new RuntimeException('Fallo al actualizar.');
    }
    eliminarPelicula($bd, $id);
    if (obtenerPelicula($bd, $id) !== false || listarPeliculas($bd, $marca . ' inexistente') !== []) {
        throw new RuntimeException('Fallo al eliminar o consultar resultados vacíos.');
    }
    echo "Persistencia y búsqueda: correctas.\n";
} finally {
    $bd->rollBack();
}
