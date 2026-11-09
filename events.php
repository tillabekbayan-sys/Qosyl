<?php
require_once __DIR__ . '/includes/init.php';

$events = [
    ['category' => 'Білім', 'number' => '01 / БІЛІМ', 'icon' => '✧',
     'title' => 'Білім беру кездесуі',
     'text' => 'Жаңа идеялармен танысып, білім көкжиегіңді кеңейт.',
     'meta' => 'Онлайн · Қатысу тегін'],
    ['category' => 'Технология', 'number' => '02 / IT', 'icon' => '⌘',
     'title' => 'IT және технология',
     'text' => 'Цифрлық технологиялар мен жаңа жобалар туралы біл.',
     'meta' => 'Офлайн · Тіркелу қажет'],
    ['category' => 'Шығармашылық', 'number' => '03 / ART', 'icon' => '✺',
     'title' => 'Шығармашылық клуб',
     'text' => 'Өз қабілетіңді көрсетіп, шығармашылық ортаға қосыл.',
     'meta' => 'Офлайн · Барлығына ашық'],
];

// $_GET арқылы келген сүзгі мен іздеу сөзі
$categories = ['Білім', 'Технология', 'Шығармашылық'];
$category = $_GET['category'] ?? 'all';
if ($category !== 'all' && !in_array($category, $categories, true)) {
    $category = 'all';
}
$search = trim($_GET['q'] ?? '');

$visible = array_filter($events, function ($ev) use ($category, $search) {
    if ($category !== 'all' && $ev['category'] !== $category) {
        return false;
    }
    if ($search !== '' && mb_stripos($ev['title'] . ' ' . $ev['text'], $search) === false) {
        return false;
    }
    return true;
});

$pageTitle = 'Qosyl — Іс-шаралар';
require __DIR__ . '/includes/header.php';
?>

<main class="events-page">
    <section class="events-intro">
        <span class="tag">ӨЗІҢЕ САЙ ІС-ШАРАНЫ ТАП</span>
        <h1>Іс-шаралар</h1>
        <p>Жаңа білім, қызықты кездесулер және ерекше әсерлер.</p>
    </section>

    <form class="filter-bar" action="events.php" method="GET">
        <label for="eventFilter">Санат бойынша сүзгі:</label>
        <select id="eventFilter" name="category">
            <option value="all">Барлық іс-шаралар</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="q" placeholder="Іздеу..." value="<?= e($search) ?>">
        <button type="submit" class="btn">Іздеу</button>
    </form>

    <div class="event-grid">
        <?php foreach ($visible as $ev): ?>
        <article class="event-card" data-category="<?= e($ev['category']) ?>">
            <span class="event-number"><?= e($ev['number']) ?></span>
            <div class="event-icon"><?= e($ev['icon']) ?></div>
            <h2><?= e($ev['title']) ?></h2>
            <p><?= e($ev['text']) ?></p>
            <div class="event-meta"><?= e($ev['meta']) ?></div>
            <a href="register.php" class="btn">Қатысу</a>
        </article>
        <?php endforeach; ?>
    </div>
    <p id="noEvents" class="form-message" <?= $visible ? 'hidden' : '' ?>>Бұл санатта іс-шара жоқ.</p>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
