<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function all()
    {
        return $this->db
            ->query("SELECT id, name, email FROM users")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare(
            "SELECT id, name, email FROM users WHERE id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        // Basic validations
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return false;
        }

        // Confirm password
        if ($data['password'] !== ($data['password_confirm'] ?? '')) {
            return false;
        }

        // Avoid duplicates
        if ($this->findByEmail($data['email'])) {
            return false;
        }

        // Use ARGON2ID if available, else BCRYPT as secure fallback
        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
        $hashedPassword = password_hash($data['password'], $algo);

        // Dynamic query matching the data provided
        // This avoids crashing if the 'google_id' column is missing in the DB
        // for normal registrations.
        if (isset($data['google_id'])) {
            $stmt = $this->db->prepare("
                INSERT INTO users (name, email, password, google_id)
                VALUES (:name, :email, :password, :google_id)
            ");
            return $stmt->execute([
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'password' => $hashedPassword,
                'google_id' => $data['google_id'],
            ]);
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO users (name, email, password)
                VALUES (:name, :email, :password)
            ");
            return $stmt->execute([
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'password' => $hashedPassword,
            ]);
        }
    }

    public function updateGoogleId($userId, $googleId)
    {
        $stmt = $this->db->prepare("UPDATE users SET google_id = :google_id WHERE id = :id");
        return $stmt->execute([
            'google_id' => $googleId,
            'id' => $userId
        ]);
    }
}

