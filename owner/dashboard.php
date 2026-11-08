<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_role('owner');
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Owner Dashboard</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="dashboard-page">
<header class="topbar"><div class="brand"><div class="brand-mark">ϟ</div><strong>Ermie-Lito Battery Center</strong></div><a class="logout-link" href="../logout.php">Log out</a></header>
<main class="dashboard-content">
    <p class="eyebrow">OWNER WORKSPACE</p>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>!</h1>
    <p class="subtitle">Owner access confirmed.</p>
    <div class="dashboard-card"><h2>Owner dashboard placeholder</h2><p>Build sales reports, inventory management, employee accounts, and store settings here.</p></div>
</main></body></html>
