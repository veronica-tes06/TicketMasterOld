<?php
// Shared validation logic for email and password used by controllers
function validateCredentials(string $email, string $password): array {
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

?>
