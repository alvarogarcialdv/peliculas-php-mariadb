<?php
declare(strict_types=1);

function escapar(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function mostrar(string $vista, array $datos = [], int $estado = 200): void
{
    http_response_code($estado);
    extract($datos, EXTR_SKIP);
    require __DIR__ . '/../vistas/plantilla.php';
}

function redirigir(string $ruta): void
{
    header('Location: ' . $ruta, true, 303);
}

function campoCsrf(): void
{
    echo '<input type="hidden" name="csrf" value="' . escapar($_SESSION['csrf']) . '">';
}
