<?php
// Әр беттің ең басында қосылады: сессия, дерекқор, көмекші функциялар.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';

// XSS-тен қорғау: экранға шығарар алдында әрдайым қолданамыз
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
