<?php
declare(strict_types=1);

function listarPeliculas(PDO $bd, string $busqueda): array
{
    // Escapamos los comodines para buscar literalmente el texto introducido.
    $patron = '%' . strtr($busqueda, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
    $consulta = $bd->prepare("SELECT * FROM peliculas WHERE titulo LIKE ? ESCAPE '!' ORDER BY titulo ASC, anio ASC, id ASC");
    $consulta->execute([$patron]);
    return $consulta->fetchAll();
}

function obtenerPelicula(PDO $bd, string $id): array|false
{
    $consulta = $bd->prepare('SELECT * FROM peliculas WHERE id = ?');
    $consulta->execute([$id]);
    return $consulta->fetch();
}

function guardarPelicula(PDO $bd, array $datos, ?string $id = null): string
{
    $valores = [$datos['titulo'], $datos['director'], $datos['anio'], $datos['genero'], $datos['sinopsis']];
    if ($id === null) {
        $consulta = $bd->prepare('INSERT INTO peliculas (titulo, director, anio, genero, sinopsis) VALUES (?, ?, ?, ?, ?)');
    } else {
        $consulta = $bd->prepare('UPDATE peliculas SET titulo = ?, director = ?, anio = ?, genero = ?, sinopsis = ? WHERE id = ?');
        $valores[] = $id;
    }
    $consulta->execute($valores);
    return $id ?? $bd->lastInsertId();
}

function eliminarPelicula(PDO $bd, string $id): void
{
    $consulta = $bd->prepare('DELETE FROM peliculas WHERE id = ?');
    $consulta->execute([$id]);
}
