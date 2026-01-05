<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Usuario</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="container">
        <h1>Usuario #<?= $user['id'] ?></h1>

        <div class="form-group" style="padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <label>Nombre:</label>
            <div style="font-size: 1.1rem; color: white;"><?= htmlspecialchars($user['name'] ?? 'Sin nombre') ?></div>
        </div>

        <div class="form-group" style="padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <label>Email:</label>
            <div style="font-size: 1.1rem; color: white;"><?= htmlspecialchars($user['email']) ?></div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="/users" class="back-link"
                style="margin-top:0; flex: 1; border: 1px solid var(--border); border-radius: 8px; padding: 10px;">Volver</a>
            <!-- <a href="/users/<?= $user['id'] ?>/edit" class="btn-primary" style="text-decoration: none; text-align: center; flex: 1;">Editar</a> -->
        </div>
    </div>

</body>

</html>