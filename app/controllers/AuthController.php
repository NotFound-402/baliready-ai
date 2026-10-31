<?php

class AuthController
{
    private PDO $pdo;
    private UserModel $userModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo);
    }

    public function register(array $input): array
    {
        if (!isset($input['csrf_token']) || !validate_csrf($input['csrf_token'])) {
            return ['success' => false, 'message' => 'Token CSRF tidak valid.'];
        }

        $name = trim((string) ($input['name'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if ($name === '' || $email === '' || $password === '') {
            return ['success' => false, 'message' => 'Semua field wajib diisi.'];
        }

        return $this->userModel->register($name, $email, $password);
    }

    public function login(array $input): array
    {
        if (!isset($input['csrf_token']) || !validate_csrf($input['csrf_token'])) {
            return ['success' => false, 'message' => 'Token CSRF tidak valid.'];
        }

        $email = strtolower(trim((string) ($input['email'] ?? '')));
        $password = (string) ($input['password'] ?? '');

        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Email dan password wajib diisi.'];
        }

        $user = $this->userModel->login($email, $password);

        if (!$user) {
            return ['success' => false, 'message' => 'Email atau password salah.'];
        }

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        return ['success' => true, 'message' => 'Login berhasil.', 'user' => $user];
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
