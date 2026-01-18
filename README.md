# Secure PHP Project

![Version](https://img.shields.io/badge/Version-1.0.1-blue?style=for-the-badge)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![Security](https://img.shields.io/badge/Security-Argon2id-blue?style=for-the-badge&logo=security)

> A robust and secure web application built with pure (Vanilla) PHP, following professional design patterns (MVC) and 2026 security best practices.

---

## Main Features

### Advanced Security
*   **Robust Authentication:** Secure login with password hashing using **Argon2id**.
*   **Rate Limiting:** Automatic protection against brute force (IP blocking for 15 min after 10 failed attempts).
*   **CSRF Protection:** Unique cryptographic tokens per session on all forms.
*   **Security Headers:** Implementation of CSP, X-Frame-Options, and Anti-MIME sniffing.
*   **Secure Cookies:** Pre-configured `HttpOnly`, `Secure`, and `SameSite=Strict` flags.
*   **Audit Logs:** Detailed activity log (Login, Logout, Failed attempts).

### User Interface (UI/UX)
*   **Glassmorphism Design:** Modern interface with blur effects and dark mode.
*   **Professional Dashboard:** Panel with sidebar, visual statistics, and cards.
*   **Responsive:** Adaptable to any device.
*   **Visual Feedback:** Clear alerts and status messages.

### Functionalities
*   **User Management:** Complete CRUD (Create, Read, Edit, List).
*   **Google Login:** Native integration with OAuth 2.0.
*   **Activity Dashboard:** Access history for the user.
*   **Integrity:** Randomly generated unique IDs.

---

## Installation and Configuration

### 1. Requirements
*   Web Server (Apache/Nginx)
*   PHP 8.0 or higher
*   MySQL / MariaDB (with PDO support)

### 2. Database Configuration
Edit `config/database.php` with your credentials:

```php
$host = 'localhost';
$db   = 'appdb';
$user = 'your_user';
$pass = 'your_password';
```

### 3. Google Login (Optional)
To enable the "Sign in with Google" button:
1.  Create a project in [Google Cloud Console](https://console.cloud.google.com/).
2.  Get your `CLIENT_ID` and `CLIENT_SECRET`.
3.  Add them in `controllers/AuthController.php`.

---

## Project Structure

```text
/www
├── assets/          # CSS Styles (Glassmorphism)
├── config/          # DB Configuration
├── controllers/     # Business Logic (Auth, User, Home)
├── core/            # Core (Router, Logger, RateLimiter)
├── helpers/         # Auxiliary Functions (CSRF, Auth)
├── models/          # Data Models (User)
├── views/           # HTML Views (Auth, Dashboard, Users)
└── index.php        # Entry Point
```

---

<details>
<summary><strong>🇪🇸 Versión en Español</strong></summary>

## Proyecto PHP Seguro

> Una aplicación web robusta y segura construida con PHP puro (Vanilla), siguiendo patrones profesionales de diseño (MVC) y las mejores prácticas de seguridad de 2026.

### Características Principales

#### Seguridad Avanzada
*   **Autenticación Robusta:** Login seguro con hasheo de contraseñas usando **Argon2id**.
*   **Rate Limiting:** Protección automática contra fuerza bruta (bloqueo de IP por 15 min tras 10 intentos fallidos).
*   **Protección CSRF:** Tokens criptográficos únicos por sesión en todos los formularios.
*   **Headers de Seguridad:** Implementación de CSP, X-Frame-Options, y Anti-MIME sniffing.
*   **Cookies Seguras:** Banderas `HttpOnly`, `Secure` y `SameSite=Strict` preconfiguradas.
*   **Logs de Auditoría:** Registro detallado de actividad (Login, Logout, Intentos fallidos).

#### Interfaz de Usuario (UI/UX)
*   **Diseño Glassmorphism:** Interfaz moderna con efectos de desenfoque y modo oscuro.
*   **Dashboard Profesional:** Panel con sidebar, estadísticas visuales y cards.
*   **Responsive:** Adaptable a cualquier dispositivo.
*   **Feedback Visual:** Alertas y mensajes de estado claros.

#### Funcionalidades
*   **Gestión de Usuarios:** CRUD completo (Crear, Leer, Editar, Listar).
*   **Google Login:** Integración nativa con OAuth 2.0.
*   **Dashboard de Actividad:** Historial de accesos para el usuario.
*   **Integridad:** IDs únicos generados aleatoriamente.

### Instalación y Configuración

1.  **Requisitos:** Servidor Web, PHP 8.0+, MySQL/MariaDB.
2.  **Configuración BD:** Edita `config/database.php`.
3.  **Google Login:** Agrega credenciales en `controllers/AuthController.php`.

</details>
