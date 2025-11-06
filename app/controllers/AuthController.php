<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private function validateCredentials(string $email, string $password): array {
        $error = '';

        // append @gmail.com if missing
        if (!str_ends_with($email, '@gmail.com')) {
            $email .= '@gmail.com';
        }

        // validate email format
        if (!preg_match('/^[A-Za-z0-9]+@gmail\.com$/', $email)) {
            $error = 'Email must contain only letters and numbers before @gmail.com.';
        } elseif (strlen($email) < 1 || strlen($email) > 30) {
            $error = 'Email must be between 1 and 30 characters (including @gmail.com).';
        }
        
        // validate password format
        elseif (!preg_match('/^[A-Za-z0-9]{8,20}$/', $password)) {
            $error = 'Password must be 8 to 20 characters long and only contain letters or numbers.';
        }

        return [$email, $error];
    }

    // Process login, return error string on failure or null on success (redirects on success)
    public function login($email, $password) {
        // Use controller validation
        [$email, $error] = $this->validateCredentials($email, $password);
        if ($error) return $error;

        $user = new User($email, $password);
        if ($user->login()) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['user'] = [
                'accID' => $user->getId(),
                'accEmail' => $user->getEmail(),
                'accAdmin' => (int)$user->isAdmin(),
                'accBookings' => $user->getBookings(),
            ];

            // Redirect to appropriate page (public pages are in the same folder)
            header('Location: events.php');
            exit();
        }

        return 'Invalid email or password.';
    }

    // Process registration, returns error string on failure or null on success (redirects on success)
    public function register($email, $password) {
        [$email, $error] = $this->validateCredentials($email, $password);
        if ($error) return $error;

        $user = new User($email, $password);
        if ($user->register()) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['user'] = [
                'accID' => $user->getId(),
                'accEmail' => $user->getEmail(),
                'accAdmin' => (int)$user->isAdmin(),
                'accBookings' => $user->getBookings(),
            ];
            header('Location: events.php');
            exit();
        }

        return 'Account creation failed (maybe email exists).';
    }
}
