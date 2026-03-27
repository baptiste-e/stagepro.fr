<?php
// public/index.php

// 1. Chargement de l'autoloader de Composer (indispensable pour Twig)
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// 2. Initialisation du moteur de template Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true
]);

// Ajout des variables globales pour Twig
$twig->addGlobal('session', $_SESSION);
$twig->addGlobal('cookie_consent', $_COOKIE['cookie_consent'] ?? null);

// 3. Imports de tous les contrôleurs
require_once '../config/Database.php';
require_once '../app/Controllers/OffreController.php';
require_once '../app/Controllers/EntrepriseController.php';
require_once '../app/Controllers/EtudiantController.php';
require_once '../app/Controllers/PiloteController.php';
require_once '../app/Controllers/AdminController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/CandidatureController.php';
require_once '../app/Controllers/WishlistController.php';

// 4. Récupération des paramètres de l'URL
$page = $_GET['page'] ?? 'home';
$id = (int) ($_GET['id'] ?? 0);

// 5. Aiguillage (Routing) global
switch ($page) {
    case 'home':
        echo $twig->render('home.html.twig', [
            'titre_page' => "Accueil | StagePro"
        ]);
        break;

    // --- COOKIES ---
    case 'cookie-accept':
        setcookie('cookie_consent', 'accepted', ['expires' => time() + 365*24*60*60, 'path' => '/', 'samesite' => 'Lax']);
        header('Location: index.php?page=home');
        exit;

    case 'cookie-refuse':
        setcookie('cookie_consent', 'refused', ['expires' => time() + 365*24*60*60, 'path' => '/', 'samesite' => 'Lax']);
        header('Location: index.php?page=home');
        exit;

    case 'cookie-reset':
        setcookie('cookie_consent', '', ['expires' => time() - 3600, 'path' => '/', 'samesite' => 'Lax']);
        header('Location: index.php?page=home');
        exit;

    // --- SECTION OFFRES ---
    case 'offres':
        (new OffreController($twig))->index();
        break;

    case 'offre-detail':
        (new OffreController($twig))->show($id);
        break;

    case 'offre-create':
        // Appel correct sans argument (id sera 0 par défaut dans le contrôleur)
        (new OffreController($twig))->create(); 
        break;

    case 'offre-edit':
        // Appel correct avec l'ID pour l'édition
        (new OffreController($twig))->create($id); 
        break;

    case 'offre-save':
        (new OffreController($twig))->save();
        break;

    case 'offre-delete':
        (new OffreController($twig))->delete($id);
        break;

    case 'offres-stats':
        (new OffreController($twig))->stats();
        break;

    // --- SECTION ENTREPRISES ---
    case 'entreprises':
        (new EntrepriseController($twig))->index();
        break;

    case 'entreprise-detail':
        (new EntrepriseController($twig))->show($id);
        break;

    case 'entreprise-create':
        (new EntrepriseController($twig))->create();
        break;

    case 'entreprise-edit':
        (new EntrepriseController($twig))->edit($id);
        break;

    case 'entreprise-save':
        (new EntrepriseController($twig))->save();
        break;

    case 'entreprise-update':
        (new EntrepriseController($twig))->update();
        break;

    case 'entreprise-delete':
        (new EntrepriseController($twig))->delete();
        break;

    // --- SECTION CANDIDATURES ---
    case 'candidatures':
        (new CandidatureController($twig))->index();
        break;

    case 'postuler':
        (new CandidatureController($twig))->postuler();
        break;

    case 'candidature-cancel':
        (new CandidatureController($twig))->cancel($id);
        break;

    case 'candidature-detail':
        (new CandidatureController($twig))->show($id);
        break;

    // --- SECTION WISHLIST ---
    case 'wishlist':
        (new WishlistController($twig))->index();
        break;

    case 'wishlist-add':
        (new WishlistController($twig))->add();
        break;

    case 'wishlist-remove':
        (new WishlistController($twig))->remove();
        break;

    // --- ADMINISTRATION ---
    case 'admin':
        (new AdminController($twig))->dashboard();
        break;

    case 'pilotes':
        (new PiloteController($twig))->index();
        break;

    case 'pilote-detail':
        (new PiloteController($twig))->show($id);
        break;

    case 'pilote-create':
        (new PiloteController($twig))->create();
        break;

    case 'pilote-edit':
        (new PiloteController($twig))->edit($id);
        break;

    case 'pilote-save':
        (new PiloteController($twig))->save();
        break;

    case 'pilote-delete':
        (new PiloteController($twig))->delete();
        break;

    case 'etudiants':
        (new EtudiantController($twig))->index();
        break;

    case 'etudiant-detail':
        (new EtudiantController($twig))->show($id);
        break;

    case 'etudiant-create':
        (new EtudiantController($twig))->create();
        break;

    case 'etudiant-edit':
        (new EtudiantController($twig))->edit($id);
        break;

    case 'etudiant-save':
        (new EtudiantController($twig))->save();
        break;

    case 'etudiant-delete':
        (new EtudiantController($twig))->delete();
        break;

    // --- AUTHENTIFICATION ---
    case 'login':
        (new AuthController($twig))->login();
        break;

    case 'logout':
        (new AuthController($twig))->logout();
        break;

    // --- DIVERS ---
    case 'mentions':
        echo $twig->render('layout/mentions.html.twig', ['titre_page' => "Mentions Légales | StagePro"]);
        break;

    default:
        http_response_code(404);
        echo $twig->render('layout/404.html.twig', ['titre_page' => "404 - Page non trouvée"]);
        break;
}