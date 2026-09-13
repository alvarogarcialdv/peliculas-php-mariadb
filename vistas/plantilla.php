<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escapar($titulo) ?> · Aplicación de películas</title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
    <header><nav><a href="<?= escapar(urlRuta('/peliculas')) ?>">Aplicación de películas</a></nav></header>
    <main>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <p class="aviso" role="status"><?= escapar($_SESSION['mensaje']) ?></p>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        <h1><?= escapar($titulo) ?></h1>
        <?php require __DIR__ . '/' . $vista . '.php'; ?>
    </main>
</body>
</html>
