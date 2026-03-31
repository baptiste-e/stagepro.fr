<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Réinitialisation session avant les tests
|--------------------------------------------------------------------------
*/
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}

/*
|--------------------------------------------------------------------------
| Outils de test
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/Support/TwigSpy.php';

/*
|--------------------------------------------------------------------------
| Chargement des contrôleurs réels
|--------------------------------------------------------------------------
| Adapte uniquement ces chemins si ton arborescence diffère.
*/
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/CandidatureController.php';