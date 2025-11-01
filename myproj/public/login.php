<?php
// Entry point for login (public)
require_once __DIR__ . '/../app/controllers/AuthController.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $controller = new AuthController();
    $error = $controller->login($email, $password);
}

// show view
require __DIR__ . '/../app/views/auth/login.php';
