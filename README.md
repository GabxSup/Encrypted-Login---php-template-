# Secure PHP Project

Una aplicación web robusta y segura construida con PHP puro (Vanilla), siguiendo patrones profesionales de diseño (MVC) y las mejores prácticas de seguridad de 2026.

## 🚀 Características Principales

### 🛡️ Seguridad Avanzada
- **Autenticación Robusta:** Login seguro con hasheo de contraseñas usando **Argon2id**.
- **Rate Limiting:** Protección automática contra fuerza bruta (bloqueo de IP por 15 min tras 10 intentos fallidos).
- **Protección CSRF:** Tokens criptográficos únicos por sesión en todos los formularios.
- **Headers de Seguridad:** Implementación de CSP, X-Frame-Options, y Anti-MIME sniffing.
- **Cookies Seguras:** Banderas `HttpOnly`, `Secure` y `SameSite=Strict` preconfiguradas.
- **Logs de Auditoría:** Registro detallado de actividad (Login, Logout, Intentos fallidos) visible en el Dashboard.

### 💻 Interfaz de Usuario (UI/UX)
- **Diseño Glassmorphism:** Interfaz moderna y atractiva con efectos de desenfoque y modo oscuro.
- **Dashboard Profesional:** Panel de control con sidebar, estadísticas visuales y cards de perfil.
- **Responsive:** Funciona perfectamente en móviles y escritorio.
- **Feedback Visual:** Mensajes de error claros y alertas de estado (colores por severidad).

### 🔑 Funcionalidades
- **Gestión de Usuarios:** CRUD completo (Crear, Leer, Editar, Listar).
- **Google Login:** Integración nativa con OAuth 2.0 (Google) para inicio de sesión rápido.
- **Dashboard de Actividad:** El usuario puede ver su propio historial de accesos para detectar intrusos.
- **Verificación de Integridad:** ID de referencia único generado aleatoriamente en cada creación de usuario.

## 🛠️ Instalación y Configuración

1. **Requisitos:**
   - Servidor Web (Apache/Nginx)
   - PHP 8.0 o superior
   - MySQL / MariaDB (con soporte PDO)

2. **Configuración de Base de Datos:**
   Edita `config/database.php` con tus credenciales.
   ```php
   $host = 'localhost';
   $db   = 'appdb';
   $user = 'tu_usuario';
   $pass = 'tu_password';
   ```

3. **Login con Google (Opcional):**
   Para activar el botón de "Iniciar con Google":
   - Crea un proyecto en [Google Cloud Console](https://console.cloud.google.com/).
   - Obtén tu `CLIENT_ID` y `CLIENT_SECRET`.
   - Agrégalos en `controllers/AuthController.php`.

## 📂 Estructura del Proyecto

```
/www
├── assets/          # Estilos CSS (Glassmorphism)
├── config/          # Configuración de BD
├── controllers/     # Lógica de negocio (Auth, User, Home)
├── core/            # Núcleo (Router, Logger, RateLimiter)
├── helpers/         # Funciones auxiliares (CSRF, Auth)
├── models/          # Modelos de datos (User)
├── views/           # Vistas HTML (Auth, Dashboard, Users)
└── index.php        # Punto de entrada
```

## 🔒 Buenas Prácticas Implementadas
Este proyecto no usa frameworks pesados para mantener el rendimiento al máximo, pero implementa manualmente mecanismos de seguridad de nivel empresarial para garantizar la integridad de los datos y la protección del usuario.
