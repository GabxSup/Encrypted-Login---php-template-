<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Nuevo usuario</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/users" id="registerForm">
        <!-- Token CSRF para seguridad -->
        <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
        
        <!-- ID único de creación (Visual) -->
        <div class="form-group">
            <label for="ref_code">Código de Referencia:</label>
            <input type="text" id="ref_code" value="<?= $creation_id ?? 'N/A' ?>" readonly 
                   style="opacity: 0.7; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label for="name">Nombre Completo:</label>
            <input type="text" id="name" name="name" placeholder="Ej: Juan Pérez" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" placeholder="usuario@ejemplo.com" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmar Contraseña:</label>
             <div class="password-wrapper">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Repite tu contraseña" required>
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirm')">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
             </div>
        </div>

        <button type="submit" class="btn-primary">Crear Usuario</button>
    </form>

    <a href="/users" class="back-link">&larr; Volver a la lista</a>
</div>

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

</body>
</html>