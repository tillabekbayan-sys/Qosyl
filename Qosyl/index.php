<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Qosyl — Іс-шаралар платформасы';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <p class="label">ЖАҢА МҮМКІНДІКТЕР ОСЫНДА БАСТАЛАДЫ</p>

        <h1>Өзіңе ұнайтын іс-шараны тап және <span>Qosyl!</span></h1>

        <p class="description">
            Концерттерге, конференцияларға, семинарлар мен
            қызықты кездесулерге оңай тіркел.
        </p>

        <a href="events.php" class="main-button">
            Іс-шараларды көру →
        </a>
    </div>
</section>

<section class="features">
    <h2>Qosyl мүмкіндіктері</h2>
    <p class="section-description">
        Қызықты іс-шараларды табу енді оңай.
    </p>

    <div class="cards">
        <div class="card">
            <div class="emoji">🎉</div>
            <h3>Іс-шаралар</h3>
            <p>Өзіңе қызықты іс-шараларды бір жерден тап.</p>
        </div>

        <div class="card">
            <div class="emoji">🔎</div>
            <h3>Іздеу және сүзгі</h3>
            <p>Іс-шараларды атауы, күні және санаты бойынша ізде.</p>
        </div>

        <div class="card">
            <div class="emoji">📝</div>
            <h3>Онлайн тіркелу</h3>
            <p>Таңдаған іс-шараңа сайт арқылы тіркел.</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
