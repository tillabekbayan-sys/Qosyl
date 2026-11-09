<?php
require_once __DIR__ . '/includes/init.php';

// Кірген адам логин бетінде қалмайды
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
$success = '';
$email = '';

// $_GET арқылы келетін хабарламалар
if (isset($_GET['registered'])) {
    $success = 'Тіркелу сәтті аяқталды! Енді жүйеге кіріңіз.';
} elseif (isset($_GET['logout'])) {
    $success = 'Сіз жүйеден шықтыңыз.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email мен құпиясөзді енгізіңіз.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email дұрыс емес.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, full_name, password_hash FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];

                header('Location: index.php');
                exit;
            }
            $errors[] = 'Email немесе құпиясөз қате.';
        } catch (PDOException $ex) {
            $errors[] = 'Серверде қате болды. database.sql импортталғанын тексеріңіз.';
        }
    }
}

$pageTitle = 'Qosyl — Кіру';
require __DIR__ . '/includes/header.php';
?>

<main class="form-page">
    <form class="form-card" id="loginForm" action="login.php" method="POST">
        <span class="tag">ҚАЙТА ОРАЛҒАНЫҢА ҚУАНЫШТЫМЫЗ</span>
        <h1>Қош келдің!</h1>
        <p class="form-description">Аккаунтыңа кіру үшін мәліметтерді енгіз.</p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <div><?= e($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" name="email"
               placeholder="example@mail.com"
               value="<?= e($email) ?>" required>

        <label for="loginPassword">Құпиясөз</label>
        <input type="password" id="loginPassword" name="password"
               placeholder="Құпиясөзіңіз" required>

        <button type="submit" class="btn full-btn">Кіру</button>
        <p id="loginMessage" class="form-message" aria-live="polite"></p>

        <p class="form-bottom">Аккаунтыңыз жоқ па?
            <a href="register.php">Тіркелу</a>
        </p>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
