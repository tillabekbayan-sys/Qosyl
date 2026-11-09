<?php
require_once __DIR__ . '/includes/init.php';

$errors = [];
$old = ['full_name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    $old = ['full_name' => $fullName, 'email' => $email];

    // --- Серверде тексеру ---
    if ($fullName === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = 'Барлық өрісті толтырыңыз.';
    }
    if ($fullName !== '' && (mb_strlen($fullName) < 2 || mb_strlen($fullName) > 100)) {
        $errors[] = 'Аты-жөні 2-ден 100 таңбаға дейін болуы керек.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email дұрыс емес.';
    }
    if ($password !== '' && strlen($password) < 6) {
        $errors[] = 'Құпиясөз кемінде 6 таңбадан тұруы керек.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Құпиясөздер бірдей емес!';
    }

    // --- Дерекқорға жазу ---
    if (!$errors) {
        try {
            $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $check->execute([$email]);

            if ($check->fetch()) {
                $errors[] = 'Бұл email бұрын тіркелген.';
            } else {
                $insert = $pdo->prepare(
                    'INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)'
                );
                $insert->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT)]);

                header('Location: login.php?registered=1');
                exit;
            }
        } catch (PDOException $ex) {
            $errors[] = 'Серверде қате болды. database.sql импортталғанын тексеріңіз.';
        }
    }
}

$pageTitle = 'Тіркелу — Qosyl';
$extraHead = <<<'HTML'
    <style>
        .register-container {
            max-width: 450px;
            margin: 60px auto;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.07);
        }

        .register-container h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .register-container p {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .register-container input {
            width: 100%;
            padding: 13px;
            margin: 8px 0 18px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 15px;
        }

        .register-container label {
            font-weight: bold;
        }

        .register-container button {
            width: 100%;
            padding: 14px;
            background: #7357e8;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .register-container button:hover {
            background: #5c42cb;
        }

        .register-container .login-link {
            margin-top: 20px;
        }

        .register-container a {
            color: #7357e8;
            text-decoration: none;
        }
    </style>
HTML;
require __DIR__ . '/includes/header.php';
?>

<div class="register-container">

    <h1>Тіркелу</h1>
    <p>Qosyl платформасына қош келдіңіз!</p>

    <?php if ($errors): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= e($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">

        <label>Аты-жөніңіз</label>
        <input type="text" name="full_name"
               placeholder="Аты-жөніңізді енгізіңіз"
               value="<?= e($old['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email"
               placeholder="Email енгізіңіз"
               value="<?= e($old['email']) ?>" required>

        <label>Құпиясөз</label>
        <input type="password" name="password"
               placeholder="Құпиясөз ойлап табыңыз"
               minlength="6" required>

        <label>Құпиясөзді қайталаңыз</label>
        <input type="password" name="confirm_password"
               placeholder="Құпиясөзді қайталаңыз"
               minlength="6" required>

        <button type="submit">Тіркелу</button>

    </form>

    <p class="login-link">
        Аккаунтыңыз бар ма?
        <a href="login.php">Кіру</a>
    </p>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
