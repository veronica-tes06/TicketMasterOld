<?php
// Entry point for registration (moved to public/)
require_once __DIR__ . '/../app/controllers/AuthController.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $controller = new AuthController();
    $error = $controller->register($email, $password);
}

// show view
require __DIR__ . '/../app/views/register.php';
