<?php

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => strtolower(trim($email))]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function register(string $name, string $email, string $password): array
    {
        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === '' || $email === '' || $password === '') {
            return ['success' => false, 'message' => 'Nama, email, dan password wajib diisi.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Format email tidak valid.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password minimal 6 karakter.'];
        }

        if ($this->findByEmail($email)) {
            return ['success' => false, 'message' => 'Email sudah terdaftar. Silakan login.'];
        }

        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'student',
        ]);

        return ['success' => true, 'message' => 'Registrasi berhasil. Silakan login.'];
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }

    public function getStudents(): array
    {
        $stmt = $this->pdo->query('SELECT id, name, email, role, created_at FROM users WHERE role = "student" ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
}
