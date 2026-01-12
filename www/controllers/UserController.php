<?php

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/Lang.php';

// Set language
if (session_status() === PHP_SESSION_NONE)
    session_start();
$lang = $_SESSION['lang'] ?? 'en';
Lang::load($lang);

class UserController extends BaseController
{
    public function index()
    {
        auth_required();
        $users = (new User)->all();
        $this->view('users/index', compact('users'));
    }

    public function show($id)
    {
        auth_required();
        $user = (new User)->find($id);
        $this->view('users/show', compact('user'));
    }

    public function create()
    {
        // auth_required();
        $creation_id = bin2hex(random_bytes(4)); // Unique ID for this creation form
        $this->view('users/create', ['creation_id' => $creation_id]);
    }

    public function store()
    {
        // auth_required();
        csrf_check(); // Validate CSRF token

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users/create');
            exit;
        }

        $user = new User();

        if (!$user->create($_POST)) {
            $_SESSION['error'] = __('error_invalid_data');
            header('Location: /users/create');
            exit;
        }

        header('Location: /users');
    }

}
