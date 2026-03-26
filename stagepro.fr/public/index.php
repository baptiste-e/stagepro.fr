<?php
// public/index.php
session_start();

// 1. Imports de tous les contrôleurs
require_once '../config/Database.php';
require_once '../app/Controllers/OffreController.php';
require_once '../app/Controllers/EntrepriseController.php';
require_once '../app/Controllers/EtudiantController.php';
require_once '../app/Controllers/PiloteController.php';
require_once '../app/Controllers/AdminController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/CandidatureController.php';
require_once '../app/Controllers/WishlistController.php';

// 2. Récupération des paramètres de l'URL
$page = $_GET['page'] ?? 'home';
$id = (int)($_GET['id'] ?? 0);

// 3. Aiguillage (Routing) global
switch ($page) {
    case 'home':
        $titre_page = "Accueil | StagePro";
        include __DIR__ . '/../app/Views/layout/header.php';
        include __DIR__ . '/../app/Views/home.php';
        include __DIR__ . '/../app/Views/layout/footer.php';
        break;

    // --- SECTION OFFRES ---
    case 'offres':
        (new OffreController())->index();
        break;
    case 'offre-detail':
        (new OffreController())->show($id);
        break;
    case 'offre-create':
    case 'offre-edit':
        (new OffreController())->create($id);
        break;
    case 'offre-save':
        (new OffreController())->save();
        break;
    case 'offre-delete':
        (new OffreController())->delete($id);
        break;
    case 'offres-stats':
        (new OffreController())->stats();
        break;

    // --- SECTION ENTREPRISES ---
    case 'entreprises':
        (new EntrepriseController())->index();
        break;
    case 'entreprise-detail':
        (new EntrepriseController())->show($id);
        break;
    case 'entreprise-create':
    case 'entreprise-edit':
        (new EntrepriseController())->edit($id);
        break;
    case 'entreprise-save':   // Création (POST)
    case 'entreprise-update': // Modification (POST)
        (new EntrepriseController())->save(); 
        break;
    case 'entreprise-delete':
        (new EntrepriseController())->delete();
        break;

    // --- SECTION CANDIDATURES ---
    case 'candidatures':
        (new CandidatureController())->index();
        break;
    case 'postuler':
        (new CandidatureController())->postuler();
        break;
    case 'candidature-cancel': 
        (new CandidatureController())->cancel($id);
        break;

    case 'candidature-detail': // <--- AJOUT : Nouvelle page spécifique
    (new CandidatureController())->show($id);
    break;

    // --- SECTION WISHLIST ---
    case 'wishlist':
        (new WishlistController())->index();
        break;
    case 'wishlist-add':
        (new WishlistController())->add();
        break;
    case 'wishlist-remove':
        (new WishlistController())->remove();
        break;

    // --- ADMINISTRATION UTILISATEURS ---
    case 'admin':
        (new AdminController())->dashboard();
        break;
    case 'pilotes':
        (new PiloteController())->index();
        break;
    case 'pilote-edit':
        (new PiloteController())->edit($id);
        break;
    case 'pilote-save':
        (new PiloteController())->save();
        break;
    case 'pilote-delete':
        (new PiloteController())->delete();
        break;
    case 'etudiants':
        (new EtudiantController())->index();
        break;

    // --- AUTHENTIFICATION ---
    case 'login':
        (new AuthController())->login();
        break;
    case 'logout':
        session_destroy();
        header('Location: index.php?page=home');
        exit;

    // --- DIVERS ---
    case 'mentions':
        $titre_page = "Mentions Légales | StagePro";
        include __DIR__ . '/../app/Views/layout/header.php';
        include __DIR__ . '/../app/Views/layout/mentions.php';
        include __DIR__ . '/../app/Views/layout/footer.php';
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../app/Views/layout/header.php';
        echo "<section style='padding:5rem; text-align:center;'>
                <h1>404 - Page non trouvée</h1>
                <p>La page demandée n'existe pas.</p>
                <a href='index.php?page=home' class='btn-cta'>Retour à l'accueil</a>
              </section>";
        include __DIR__ . '/../app/Views/layout/footer.php';
        break;
}