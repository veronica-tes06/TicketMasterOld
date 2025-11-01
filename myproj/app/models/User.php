<?php
// Simple User model for myproj
class User {
    private $id;
    private $email;
    private $password;
    private $isAdmin = 0;
    private $bookings = '';

    public function __construct($email = '', $password = '') {
        $this->email = $email;
        $this->password = $password;
    }

    // getters / setters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function isAdmin() { return (bool)$this->isAdmin; }
    public function getBookings() { return $this->bookings; }

    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }

    // Attempt login against DB, returns true on success
    public function login() {
        require __DIR__ . '/../config/connect.php';

        $stmt = $db->prepare("SELECT * FROM accounts WHERE accEmail = ?");
        $stmt->execute([$this->email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['accPassword'] === $this->password) {
            $this->id = $row['accID'];
            $this->isAdmin = $row['accAdmin'];
            $this->bookings = $row['accBookings'];
            return true;
        }
        return false;
    }

    // Create a new account, returns created User object or false
    public function register() {
        require __DIR__ . '/../config/connect.php';

        // check exists
        $check = $db->prepare("SELECT accID FROM accounts WHERE accEmail = ?");
        $check->execute([$this->email]);
        if ($check->rowCount() > 0) return false;

        $insert = $db->prepare("INSERT INTO accounts (accEmail, accPassword, accBookings, accAdmin) VALUES (?, ?, '', 0)");
        if ($insert->execute([$this->email, $this->password])) {
            $this->id = $db->lastInsertId();
            return $this;
        }
        return false;
    }
}
