<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
</head>
<body>
<h1>Welcome to Events Page</h1>
<p>This is the user home page.</p>
<p>Logged in as: <?php echo htmlspecialchars($_SESSION['user']['accEmail']); ?></p>
</body>
</html>