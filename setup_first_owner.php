<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/db.php';

$count = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$message = '';
$error = '';

if ($count > 0) {
    http_response_code(403);
    exit('Setup is locked because a user account already exists. Delete setup_first_owner.php now.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $fullName === '' || strlen($password) < 8) {
        $error = 'Complete all fields. Password must be at least 8 characters.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, full_name, role, is_active) VALUES (?, ?, ?, 'owner', 1)");
        try {
            $stmt->execute([$username, $hash, $fullName]);
            $message = 'Owner account created. Delete setup_first_owner.php now, then sign in.';
        } catch (PDOException $e) {
            $error = 'Could not create account. The username may already exist.';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>First Owner Setup</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="setup-page"><main class="setup-card"><h1>Create first owner</h1><p class="subtitle">Run this once after importing database.sql.</p>
<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php else: ?>
<form method="post"><label>FULL NAME</label><input name="full_name" required><label>USERNAME</label><input name="username" maxlength="50" required><label>PASSWORD (8+ CHARACTERS)</label><input name="password" type="password" minlength="8" required><button class="login-button" type="submit">Create owner account</button></form>
<?php endif; ?></main></body></html>
