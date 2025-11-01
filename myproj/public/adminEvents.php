<?php
session_start();
if (empty($_SESSION['user']) || !$_SESSION['user']['accAdmin']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Events</title>
</head>
<body>
<h1>Welcome to Admin Events Page</h1>
<p>This is the admin dashboard.</p>
<p>Logged in as: <?php echo htmlspecialchars($_SESSION['user']['accEmail']); ?></p>
</body>
</html>