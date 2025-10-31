<?php
session_start();
require 'config/connect.php';
require 'validate.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    [$email, $error] = validateCredentials($email, $password);

    if (!$error) {
        $stmt = $db->prepare("SELECT * FROM accounts WHERE accEmail = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['accPassword'] === $password) {
            $_SESSION['user'] = [
                'accID' => $user['accID'],
                'accEmail' => $user['accEmail'],
                'accAdmin' => $user['accAdmin'],
                'accBookings' => $user['accBookings']
            ];
            if ($user['accAdmin']) {
                header('Location: adminEvents.php');
            } else {
                header('Location: events.php');
            }
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php if ($error): ?>
<p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post">
    <input type="text" name="email" placeholder="Email" required>@gmail.com<br>
    <input type="password" name="password" placeholder="Password (8–20 chars)" required><br>
    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>