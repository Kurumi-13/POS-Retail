<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    // For a production deployment, enable HTTPS and set secure => true.
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id'], $_SESSION['role']);
}

function redirect_by_role(): never {
    if (($_SESSION['role'] ?? '') === 'owner') {
        header('Location: owner/dashboard.php');
        exit;
    }

    if (($_SESSION['role'] ?? '') === 'cashier') {
        header('Location: cashier/dashboard.php');
        exit;
    }

    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

function require_role(string $role): void {
    if (!is_logged_in()) {
        header('Location: ../login.php');
        exit;
    }

    if (($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403);
        exit('Access denied.');
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
