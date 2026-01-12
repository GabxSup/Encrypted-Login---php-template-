# SecureApp

This project is a secure PHP dashboard application running on Docker. It features a robust authentication system, bilingual support, and a premium UI.

## Features

- **Authentication**: Secure login, registration, and logout (Argon2ID/Bcrypt).
- **Google Login**: Verified integration with Google OAuth.
- **Security**:
    - CSRF Protection.
    - Rate Limiting (IP-based).
    - SQL Injection protection (PDO).
    - Secure Headers.
- **Bilingual Support**: English and Spanish support via `Lang` helper.
- **UI/UX**: Premium styling with dark mode elements, responsive tables, and glassmorphism.

## Installation

### Prerequisites
- Docker & Docker Compose

### Setup

1.  **Clone the repository**:
    ```bash
    git clone <repository_url>
    cd docker-xampp
    ```

2.  **Start the containers**:
    ```bash
    docker-compose up -d
    ```

3.  **Access the application**:
    - Open `http://localhost:8000` (or your configured port).
    - Database: `http://localhost:8080` (phpMyAdmin).

4.  **Database Migration**:
    - Import the initial schema.
    - **Important**: Run `migratons/001_add_google_id.sql` to enable Google Login support.

## Implementation Details

### Bilingual Support
The application uses a lightweight `Lang` helper.
- Language files are located in `www/lang/en.php` and `www/lang/es.php`.
- The default language is English. To switch to Spanish, set `$_SESSION['lang'] = 'es'`.

### User Management
- **Create**: Supports normal registration and Google registration.
- **View**: Styled list and detail views.
- **Security**: The `User` model dynamically handles the `google_id` column to prevent crashes if the DB schema is not updated.

## Logging
User activities (login, logout, blocks) are logged to the database and displayed on the dashboard throughout the `Logger` class.
