<?php
declare(strict_types=1);

function escapar(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function urlEntrada(): string
{
    return '/index.php';
}

function urlRuta(string $ruta, array $parametros = []): string
{
    $consulta = http_build_query(['ruta' => $ruta] + $parametros, '', '&', PHP_QUERY_RFC3986);
    return urlEntrada() . '?' . $consulta;
}

function mostrar(string $vista, array $datos = [], int $estado = 200): void
{
    http_response_code($estado);
    extract($datos, EXTR_SKIP);
    require __DIR__ . '/../vistas/plantilla.php';
}

function redirigir(string $ruta, array $parametros = []): void
{
    header('Location: ' . urlRuta($ruta, $parametros), true, 303);
}

function campoCsrf(): void
{
    echo '<input type="hidden" name="csrf" value="' . escapar($_SESSION['csrf']) . '">';
}
