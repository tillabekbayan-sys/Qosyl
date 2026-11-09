<?php
// Беттен келетін айнымалылар: $pageTitle, $extraHead (міндетті емес)
$pageTitle = $pageTitle ?? 'Qosyl';
$extraHead = $extraHead ?? '';
$loggedIn  = !empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
<?= $extraHead ?>
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Qosyl<span>.</span></a>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="events.php">Іс-шаралар</a>
        <?php if ($loggedIn): ?>
            <a href="profile.php">Профиль (<?= e($_SESSION['user_name']) ?>)</a>
            <a href="logout.php" class="nav-button">Шығу</a>
        <?php else: ?>
            <a href="login.php">Кіру</a>
            <a href="register.php" class="nav-button">Тіркелу</a>
        <?php endif; ?>
    </nav>
</header>
