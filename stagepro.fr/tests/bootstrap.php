<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}

require_once __DIR__ . '/Support/TwigSpy.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/CandidatureController.php';