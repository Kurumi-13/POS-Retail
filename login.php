<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (is_logged_in()) {
    redirect_by_role();
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (!verify_csrf_token($csrf)) {
        $error = 'Your session expired. Please refresh the page and try again.';
    } elseif ($username === '' || $password === '') {
        $error = 'Please enter both your username and password.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, username, password_hash, full_name, role, is_active
             FROM users WHERE username = :username LIMIT 1'
        );
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && (int)$user['is_active'] === 1 && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            $update = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = :id');
            $update->execute(['id' => $user['id']]);

            redirect_by_role();
        } else {
            // Keep the message generic so the page does not reveal valid usernames.
            $error = 'Incorrect username or password, or this account is inactive.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Erm ie-Lito Battery Center</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="brand-panel" aria-label="Store information">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">ϟ</div>
                <span>Ermie-Lito Battery Center</span>
            </div>

            <div class="brand-message">
                <h1>Batteries &amp; LPG<br><span>Sales made simple</span></h1>
                <p>Fast Checkout, clear receipts and a clean record of every sale.</p>
            </div>
            <div class="brand-footer">RETAIL POINT OF SALE SYSTEM</div>
        </section>

        <section class="form-panel">
            <div class="login-form-wrap">
                <h2>WELCOME</h2>
                <p class="subtitle">Sign in to start your shift</p>

                <?php if ($error !== ''): ?>
                    <div class="alert alert-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php" autocomplete="on">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">

                    <label for="username">USERNAME</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M12 12a4.2 4.2 0 1 0 0-8.4A4.2 4.2 0 0 0 12 12Zm0 2c-4.2 0-7.5 2.1-7.5 4.8V21h15v-2.2c0-2.7-3.3-4.8-7.5-4.8Z"/></svg>
                        </span>
                        <input id="username" name="username" type="text" placeholder="Enter username"
                               value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                               maxlength="50" autocomplete="username" required autofocus>
                    </div>

                    <label for="password">PASSWORD</label>
                    <div class="input-wrap">
                        <span class="input-icon lock-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2ZM10 7a2 2 0 1 1 4 0v2h-4V7Zm2 11a2 2 0 0 1-1-3.73V13h2v1.27A2 2 0 0 1 12 18Z"/></svg>
                        </span>
                        <input id="password" name="password" type="password" placeholder="Enter password"
                               autocomplete="current-password" required>
                        <button class="password-toggle" type="button" id="togglePassword" aria-label="Show password">
                            <svg viewBox="0 0 24 24"><path d="M12 5c-5.2 0-9.4 4.1-10.8 6.5a.9.9 0 0 0 0 1C2.6 14.9 6.8 19 12 19s9.4-4.1 10.8-6.5a.9.9 0 0 0 0-1C21.4 9.1 17.2 5 12 5Zm0 11.5a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>
                        </button>
                    </div>

                    <button class="login-button" type="submit">Login <span aria-hidden="true">→</span></button>
                </form>
                <p class="help-text">Trouble signing in? Ask the shop owner.</p>
            </div>
        </section>
    </main>
    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        toggle.addEventListener('click', () => {
            const showing = password.type === 'text';
            password.type = showing ? 'password' : 'text';
            toggle.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        });
    </script>
</body>
</html>
