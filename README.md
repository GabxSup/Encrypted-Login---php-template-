# 🚀 PHP MVC Secure Template

Un framework MVC ligero, robusto y seguro construido con PHP nativo. Diseñado para servir como base sólida para aplicaciones web, pre-configurado con un entorno Docker (XAMPP) y mejores prácticas de seguridad.

---

## 🔥 Características Principales

- **Arquitectura MVC**: Separación clara de responsabilidades (Modelos, Vistas, Controladores).
- **Seguridad Primero**:
  - Sistema de Login/Registro con encriptación **BCrypt**.
  - Protección **CSRF** integrada en formularios.
  - Sentencias preparadas (**PDO**) para prevenir SQL Injection.
  - Validación de sesiones segura.
- **Enrutamiento Personalizado**: Sistema de rutas flexible y fácil de configurar (`routes.php`).
- **Base de Datos**: Capa de abstracción simple usando PDO Singleton.
- **Entorno Dockerizado**: Configuración lista para usar con Apache y MariaDB.

## 🛠 Requisitos

- [Docker](https://www.docker.com/) y [Docker Compose](https://docs.docker.com/compose/).
- O (si no usas Docker): Servidor Web (Apache/Nginx), PHP 8.0+ y MySQL/MariaDB.

## 🚀 Instalación y Uso

### 1. Clonar el repositorio
```bash
git clone <tu-repositorio>
cd docker-xampp
```

### 2. Iniciar el entorno (Docker)
Este proyecto incluye una configuración completa de `docker-compose`.
```bash
docker-compose up -d --build
```
Esto levantará los servicios:
- **Web Server**: Accesible en `http://localhost:80` (o el puerto configurado).
- **Base de Datos**: MariaDB.

### 3. Configuración de la Base de Datos
El archivo de conexión se encuentra en `www/config/database.php`.

Si usas el docker-compose incluido, la base de datos se autoconfigura con:
- **Host**: `mariadb`
- **DB Name**: `appdb`
- **User**: `appuser`
- **Pass**: `apppass`

**Tabla de Usuarios (SQL):**
Ejecuta este script SQL para crear la tabla inicial:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 📂 Estructura del Proyecto

```
/www
├── config/             # Configuración (DB, variables globales)
├── controllers/        # Lógica de negocio (UserController, AuthController)
├── core/               # Núcleo del framework (Router, BaseController)
├── helpers/            # Funciones auxiliares (Auth, CSRF)
├── models/             # Lógica de datos (User)
├── views/              # Plantillas HTML/PHP
├── index.php           # Punto de entrada (Front Controller)
└── routes.php          # Definición de rutas
```

## 🛡 Seguridad Implementada

### Autenticación
El sistema utiliza `password_hash()` y `password_verify()` para manejar contraseñas de forma segura. Nunca se almacenan contraseñas en texto plano.

### Protección de Rutas
Se utiliza un middleware simple `auth_required()` en los controladores para proteger rutas que requieren sesión iniciada.

```php
public function index() {
    auth_required(); // Redirige al login si no hay sesión
    // ...
}
```

## 📝 Personalización

1. **Agregar una nueva ruta**: Edita `www/routes.php`.
2. **Crear un controlador**: Hereda de `BaseController` en `www/controllers/`.
3. **Crear un modelo**: Usa `www/models/` y conecta con `$this->db`.

---
⚡ *Desarrollado como template base para proyectos ágiles y seguros.*
