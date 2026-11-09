<?php
require_once __DIR__ . '/includes/init.php';

// Тек кірген пайдаланушыға рұқсат
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT full_name, email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: logout.php');
    exit;
}

$pageTitle = 'Qosyl — Профиль';
require __DIR__ . '/includes/header.php';
?>

<main class="form-page">
    <div class="form-card">
        <span class="tag">ПРОФИЛЬ</span>
        <h1><?= e($user['full_name']) ?></h1>
        <p class="form-description">Жеке мәліметтеріңіз.</p>

        <label>Email</label>
        <p><?= e($user['email']) ?></p>

        <label>Тіркелген күні</label>
        <p><?= e($user['created_at']) ?></p>

        <a href="logout.php" class="btn full-btn" style="text-align:center">Шығу</a>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
