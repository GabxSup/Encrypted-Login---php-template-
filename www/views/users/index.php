<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <span style="color: var(--text-muted);">ID: <?= $_SESSION['user_id'] ?? '?' ?></span>
            <a href="/logout" style="color: #ef4444; text-decoration: none; font-size: 0.9rem;">Cerrar sesión</a>
        </div>

        <h1>Usuarios</h1>

        <div style="margin-bottom: 20px;">
            <a href="/users/create" class="btn-primary"
                style="text-decoration: none; display: inline-block; text-align: center;">Crear Nuevo Usuario</a>
        </div>

        <ul class="user-list">
            <?php foreach ($users as $user): ?>
                <li>
                    <a href="/users/<?= $user['id'] ?>">
                        <?= htmlspecialchars($user['email']) ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

</body>

</html>