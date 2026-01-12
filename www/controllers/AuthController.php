<?php

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../core/RateLimiter.php';
require_once __DIR__ . '/../core/Logger.php';
require_once __DIR__ . '/../helpers/Lang.php';

// Set language (basic checking from session or default)
if (session_status() === PHP_SESSION_NONE)
    session_start();
$lang = $_SESSION['lang'] ?? 'en';
Lang::load($lang);

class AuthController extends BaseController
{
    public function loginForm()
    {
        $this->view('auth/login');
    }

    public function login()
    {
        csrf_check();

        $limiter = new RateLimiter();
        $logger = new Logger();
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($limiter->isBlocked($ip)) {
            $logger->log('blocked_ip', null, $_POST['email'] ?? 'unknown', "IP Blocked due to excessive attempts");
            $_SESSION['error'] = __('error_too_many_attempts');
            $this->view('auth/login');
            exit;
        }

        $user = (new User)->findByEmail($_POST['email']);

        if (!$user) {
            $limiter->logAttempt($ip);
            $logger->log('login_failed', null, $_POST['email'], "User not found");
            $limiter->logAttempt($ip);
            $logger->log('login_failed', null, $_POST['email'], "User not found");
            $_SESSION['error'] = __('error_user_not_found'); // Specific error as requested
            $this->view('auth/login');
            exit;
        }

        if (!password_verify($_POST['password'], $user['password'])) {
            $limiter->logAttempt($ip);
            $logger->log('login_failed', null, $_POST['email'], "Invalid password");
            $limiter->logAttempt($ip);
            $logger->log('login_failed', null, $_POST['email'], "Invalid password");
            $_SESSION['error'] = __('error_incorrect_password'); // Specific error
            $this->view('auth/login');
            exit;
        }

        // Login exitoso
        $limiter->clearAttempts($ip);
        $_SESSION['user'] = $user['id'];
        $logger->log('login_success', $user['id'], $user['email']);
        $this->redirect('/');
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            (new Logger)->log('logout', $_SESSION['user']);
        }
        session_destroy();
        $this->redirect('/login');
    }


    public function loginGoogle()
    {
        // TODO: REEMPLAZAR con tus credenciales reales de Google Console
        // https://console.cloud.google.com/
        $clientID = 'TU_CLIENT_ID_DE_GOOGLE';
        $redirectUri = 'http://localhost:8000/login/google/callback'; // Ajusta el puerto/dominio

        $params = [
            'client_id' => $clientID,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'online'
        ];

        $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        header("Location: $url");
        exit;
    }

    public function loginGoogleCallback()
    {
        if (empty($_GET['code'])) {
            $this->redirect('/login');
        }

        // TODO: REEMPLAZAR con tus credenciales reales
        $clientID = 'TU_CLIENT_ID_DE_GOOGLE';
        $clientSecret = 'TU_CLIENT_SECRET_DE_GOOGLE';
        $redirectUri = 'http://localhost:8000/login/google/callback';

        // 1. Intercambiar code por access token
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $postData = [
            'code' => $_GET['code'],
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $tokenData = json_decode($response, true);
        if (!isset($tokenData['access_token'])) {
            die('Error obteniendo token de Google');
        }

        // 2. Obtener info del usuario
        $userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $tokenData['access_token']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userInfo = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $email = $userInfo['email'];
        $googleId = $userInfo['id'];
        $name = $userInfo['name'];

        // 3. Buscar o Crear usuario
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user) {
            // Usuario existe, actualizamos google_id si hace falta
            if (empty($user['google_id'])) {
                $userModel->updateGoogleId($user['id'], $googleId);
            }
            $_SESSION['user'] = $user['id'];
        } else {
            // Crear usuario nuevo automáticamente
            // Asignamos una contraseña aleatoria fuerte ya que entra por Google
            $randomPass = bin2hex(random_bytes(16));
            $userModel->create([
                'email' => $email,
                'password' => $randomPass,
                'password_confirm' => $randomPass, // Para pasar validación
                'google_id' => $googleId,
            ]);
            $newUser = $userModel->findByEmail($email);
            $_SESSION['user'] = $newUser['id'];
            (new Logger)->log('register_google', $newUser['id'], $email);
        }

        (new Logger)->log('login_google', $_SESSION['user'], $email);
        $this->redirect('/');
    }
}

