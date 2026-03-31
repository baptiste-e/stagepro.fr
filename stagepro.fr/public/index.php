<?php
/**
 * point d'entrée unique - StagePro
 */

// 1. Chargement de l'autoloader de Composer (indispensable pour Twig)
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Démarrage de la session
session_start();

// 3. Configuration de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Passer à un dossier de cache en production
    'debug' => true
]);

// Ajout des variables globales pour que Twig y ait accès dans TOUS les templates
$twig->addGlobal('session', $_SESSION);
$twig->addGlobal('cookie_consent', $_COOKIE['cookie_consent'] ?? null);

// 4. Imports des ressources système et des contrôleurs
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/Controllers/OffreController.php';
require_once __DIR__ . '/../app/Controllers/EntrepriseController.php';
require_once __DIR__ . '/../app/Controllers/EtudiantController.php';
require_once __DIR__ . '/../app/Controllers/PiloteController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/CandidatureController.php';
require_once __DIR__ . '/../app/Controllers/WishlistController.php';
require_once __DIR__ . '/../app/Controllers/SearchController.php';

// 5. Récupération des paramètres de navigation
$page = $_GET['page'] ?? 'home';
$id = (int)($_GET['id'] ?? 0);

// 6. Routeur (Aiguillage global)
switch ($page) {
    case 'home':
        echo $twig->render('home.html.twig', ['titre_page' => "Accueil | StagePro"]);
        break;

    // --- GESTION DES COOKIES (RGPD) ---
    case 'cookie-accept':
        setcookie('cookie_consent', 'accepted', ['expires' => time() + 365*24*60*60, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
        header('Location: index.php?page=home');
        exit;

    case 'cookie-refuse':
        setcookie('cookie_consent', 'refused', ['expires' => time() + 365*24*60*60, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
        header('Location: index.php?page=home');
        exit;

    case 'cookie-reset':
        setcookie('cookie_consent', '', ['expires' => time() - 3600, 'path' => '/']);
        header('Location: index.php?page=home');
        exit;

    // --- OFFRES DE STAGE ---
    case 'offres':
        (new OffreController($twig))->index();
        break;
    case 'offre-detail':
        (new OffreController($twig))->show($id);
        break;
    case 'offre-create':
        (new OffreController($twig))->create(); 
        break;
    case 'offre-edit':
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

    // --- ENTREPRISES ---
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
    case 'entreprise-evaluate':
    (new EntrepriseController($twig))->evaluate($id);
    break;
case 'entreprise-save-eval':
    (new EntrepriseController($twig))->saveEvaluation();
    break;

    // --- CANDIDATURES ---
    case 'candidatures':
        (new CandidatureController($twig))->index();
        break;
    case 'postuler':
        (new CandidatureController($twig))->postuler();
        break;
    case 'candidature-detail':
        (new CandidatureController($twig))->show($id);
        break;
    case 'candidature-cancel':
        (new CandidatureController($twig))->cancel($id);
        break;
    case 'candidature-update-status':
        (new CandidatureController($twig))->updateStatus($id);
        break;

    // --- WISHLIST (FAVORIS) ---
    case 'wishlist':
        (new WishlistController($twig))->index();
        break;
    case 'wishlist-add':
        (new WishlistController($twig))->add();
        break;
    case 'wishlist-remove':
        (new WishlistController($twig))->remove();
        break;

    // --- ADMINISTRATION & UTILISATEURS ---
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

    // --- PAGES LÉGALES ---
    case 'mentions':
        echo $twig->render('mentions_legales.html.twig');
        break;

        // --- RECHERCHE GLOBALE ---
    case 'recherche':
        (new SearchController($twig))->index();
        break;

    // --- PAGE 404 (ERREUR) ---
    default:
        http_response_code(404);
        echo $twig->render('layout/404.html.twig', ['titre_page' => "404 - Page non trouvée"]);
        break;
}