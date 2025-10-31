<?php
session_start();
require 'config/connect.php';
require 'validate.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    [$email, $error] = validateCredentials($email, $password);

    if (!$error) {
        $stmt = $db->prepare("SELECT accID FROM accounts WHERE accEmail = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = 'That email is already registered. Please log in below.';
        } else {
            $insert = $db->prepare("INSERT INTO accounts (accEmail, accPassword, accBookings, accAdmin) VALUES (?, ?, '', 0)");
            if ($insert->execute([$email, $password])) {
                $newID = $db->lastInsertId();
                $stmt = $db->prepare("SELECT * FROM accounts WHERE accID = ?");
                $stmt->execute([$newID]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['user'] = [
                    'accID' => $user['accID'],
                    'accEmail' => $user['accEmail'],
                    'accAdmin' => $user['accAdmin'],
                    'accBookings' => $user['accBookings']
                ];

                header('Location: events.php');
                exit();
            } else {
                $error = 'Account creation failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<?php if ($error): ?>
<p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post">
    <input type="text" name="email" placeholder="Email" required>@gmail.com<br>
    <input type="password" name="password" placeholder="Password (8–20 chars)" required><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>