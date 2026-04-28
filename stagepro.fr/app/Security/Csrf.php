<?php
// app/Security/Csrf.php

class Csrf
{
    /**
     * Génère un token CSRF et le stocke en session.
     */
    public static function generate(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Vérifie que le token envoyé par le formulaire correspond à celui en session.
     */
    public static function check(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_POST['csrf_token'] ?? '';

        if (
            empty($_SESSION['csrf_token']) ||
            empty($token) ||
            !hash_equals($_SESSION['csrf_token'], $token)
        ) {
            die("Erreur CSRF : action non autorisée.");
        }
    }
}