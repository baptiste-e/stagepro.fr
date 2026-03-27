<?php
require_once __DIR__ . '/../vendor/autoload.php';

class Renderer {
    private static $twig;

    public static function getTwig() {
        if (self::$twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/Views');
            self::$twig = new \Twig\Environment($loader, [
                'cache' => false, // Désactivé pour le développement
                'debug' => true
            ]);
            // On peut ajouter l'accès à la session globalement
            self::$twig->addGlobal('session', $_SESSION);
        }
        return self::$twig;
    }
}