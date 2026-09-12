<?php
declare(strict_types=1);

// Enrutador exclusivo del servidor de desarrollo de PHP.
$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($ruta === '/css/estilos.css') {
    return false;
}
require __DIR__ . '/publico/index.php';
