<?php

require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Logger.php';

class HomeController extends BaseController
{
    public function index()
    {
        auth_required();

        $authUserId = $_SESSION['user'];
        $user = (new User)->find($authUserId);

        $logger = new Logger();
        $logs = $logger->getUserLogs($authUserId);

        $this->view('home', [
            'logs' => $logs,
            'user' => $user
        ]);
    }
}
