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
        // 8️⃣ Validaciones básicas
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return false;
        }

        // Confirmar contraseña
        if ($data['password'] !== ($data['password_confirm'] ?? '')) {
            return false;
        }

        // evitar duplicados
        if ($this->findByEmail($data['email'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ");

        // Usar ARGON2ID si está disponible, sino BCRYPT como fallback seguro
        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;

        return $stmt->execute([
            'name' => trim($data['name']),
            'email' => trim($data['email']),
            'password' => password_hash($data['password'], $algo),
        ]);
    }
}

