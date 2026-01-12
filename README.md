#  Secure PHP Project

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![Security](https://img.shields.io/badge/Security-Argon2id-blue?style=for-the-badge&logo=security)

> Una aplicación web robusta y segura construida con PHP puro (Vanilla), siguiendo patrones profesionales de diseño (MVC) y las mejores prácticas de seguridad de 2026.

---

##  Características Principales

###  Seguridad Avanzada
*   **Autenticación Robusta:** Login seguro con hasheo de contraseñas usando **Argon2id**.
*   **Rate Limiting:** Protección automática contra fuerza bruta (bloqueo de IP por 15 min tras 10 intentos fallidos).
*   **Protección CSRF:** Tokens criptográficos únicos por sesión en todos los formularios.
*   **Headers de Seguridad:** Implementación de CSP, X-Frame-Options, y Anti-MIME sniffing.
*   **Cookies Seguras:** Banderas `HttpOnly`, `Secure` y `SameSite=Strict` preconfiguradas.
*   **Logs de Auditoría:** Registro detallado de actividad (Login, Logout, Intentos fallidos).

###  Interfaz de Usuario (UI/UX)
*   **Diseño Glassmorphism:** Interfaz moderna con efectos de desenfoque y modo oscuro.
*   **Dashboard Profesional:** Panel con sidebar, estadísticas visuales y cards.
*   **Responsive:** Adaptable a cualquier dispositivo.
*   **Feedback Visual:** Alertas y mensajes de estado claros.

###  Funcionalidades
*   **Gestión de Usuarios:** CRUD completo (Crear, Leer, Editar, Listar).
*   **Google Login:** Integración nativa con OAuth 2.0.
*   **Dashboard de Actividad:** Historial de accesos para el usuario.
*   **Integridad:** IDs únicos generados aleatoriamente.

---

##  Instalación y Configuración

### 1. Requisitos
*   Servidor Web (Apache/Nginx)
*   PHP 8.0 o superior
*   MySQL / MariaDB (con soporte PDO)

### 2. Configuración de Base de Datos
Edita `config/database.php` con tus credenciales:

```php
$host = 'localhost';
$db   = 'appdb';
$user = 'tu_usuario';
$pass = 'tu_password';
```

### 3. Login con Google (Opcional)
Para activar el botón de "Iniciar con Google":
1.  Crea un proyecto en [Google Cloud Console](https://console.cloud.google.com/).
2.  Obtén tu `CLIENT_ID` y `CLIENT_SECRET`.
3.  Agrégalos en `controllers/AuthController.php`.

---

##  Estructura del Proyecto

```text
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

---

<details>
<summary><strong>🇺🇸 English Version</strong></summary>

## Secure PHP Project

A robust and secure web application built with pure (Vanilla) PHP, following professional design patterns (MVC) and 2026 security best practices.

### Main Features

#### Advanced Security
- **Strong Authentication:** Secure login with password hashing using **Argon2id**.
- **Rate Limiting:** Automatic brute-force protection.
- **CSRF Protection:** Unique cryptographic tokens per session.
- **Security Headers:** CSP, X-Frame-Options, Anti-MIME sniffing.
- **Secure Cookies:** `HttpOnly`, `Secure`, `SameSite=Strict`.

#### User Interface
- **Glassmorphism Design:** Modern interface with dark mode.
- **Professional Dashboard:** Visual statistics and profile cards.
- **Responsive:** Mobile and desktop ready.

### Installation

1. **Database Config:** Edit `config/database.php`.
2. **Google Login:** Add credentials to `controllers/AuthController.php`.

</details>
