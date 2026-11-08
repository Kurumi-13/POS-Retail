<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_role('cashier');
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cashier Dashboard</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="dashboard-page">
<header class="topbar"><div class="brand"><div class="brand-mark">ϟ</div><strong>Ermie-Lito Battery Center</strong></div><a class="logout-link" href="../logout.php">Log out</a></header>
<main class="dashboard-content">
    <p class="eyebrow">CASHIER WORKSPACE</p>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>!</h1>
    <p class="subtitle">Your cashier dashboard is ready.</p>
    <div class="dashboard-card"><h2>Quick actions</h2><p>Next, connect this dashboard to your POS sales, transaction history, and inventory modules.</p><a class="login-button inline-button" href="#">Start New Sale</a></div>
</main></body></html>
