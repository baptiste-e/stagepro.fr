<?php
// public/index.php
session_start();

// 1. Imports de la configuration et des contrôleurs
require_once '../config/Database.php';
require_once '../app/Controllers/OffreController.php';
require_once '../app/Controllers/EntrepriseController.php';
require_once '../app/Controllers/EtudiantController.php';
require_once '../app/Controllers/PiloteController.php';
require_once '../app/Controllers/AdminController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/CandidatureController.php';
require_once '../app/Controllers/WishlistController.php';

// 2. Récupération des paramètres
$page = $_GET['page'] ?? 'home';
$id = (int)($_GET['id'] ?? 0);

// 3. Aiguillage (Routing)
switch ($page) {
    case 'home':
        $titre_page = "Accueil | StagePro";
        include __DIR__ . '/../app/Views/layout/header.php';
        include __DIR__ . '/../app/Views/home.php';
        include __DIR__ . '/../app/Views/layout/footer.php';
        break;

    // --- OFFRES ---
    case 'offres':
        (new OffreController())->index();
        break;
    case 'offre-detail':
        (new OffreController())->show($id);
        break;
    case 'offre-create':
    case 'offre-edit':
    case 'offre-form': 
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

    // --- ENTREPRISES ---
    case 'entreprises':
        (new EntrepriseController())->index();
        break;
    case 'entreprise-detail':
        (new EntrepriseController())->show($id);
        break;
    case 'entreprise-create':
        (new EntrepriseController())->create();
        break;
    case 'entreprise-save':
        (new EntrepriseController())->save();
        break;

    // --- ÉTUDIANTS ---
    case 'etudiants':
        (new EtudiantController())->index();
        break;
    case 'etudiant-detail':
        (new EtudiantController())->show($id);
        break;
    case 'etudiant-create':
        (new EtudiantController())->create();
        break;
    case 'etudiant-edit':
        (new EtudiantController())->edit($id);
        break;
    case 'etudiant-save':
        (new EtudiantController())->save();
        break;
    case 'etudiant-delete': 
        (new EtudiantController())->delete(); 
        break;

    // --- PILOTES ---
    case 'pilotes':
        (new PiloteController())->index();
        break;
    case 'pilote-detail':
        (new PiloteController())->show($id);
        break;
    case 'pilote-create':
        (new PiloteController())->create();
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

    // --- ADMIN & CANDIDATURES ---
    case 'admin':
        (new AdminController())->dashboard();
        break;
    case 'candidatures':
        (new CandidatureController())->index();
        break;
    case 'postuler':
        (new CandidatureController())->postuler();
        break;

    // --- WISHLIST ---
    case 'wishlist':
        (new WishlistController())->index();
        break;
    case 'wishlist-add':
        (new WishlistController())->add();
        break;
    case 'wishlist-remove':
        (new WishlistController())->remove();
        break;

    // --- DIVERS ---
    case 'mentions':
        $titre_page = "Mentions Légales | StagePro";
        include __DIR__ . '/../app/Views/layout/header.php';
        include __DIR__ . '/../app/Views/layout/mentions.php';
        include __DIR__ . '/../app/Views/layout/footer.php';
        break;

    case 'login':
        (new AuthController())->login();
        break;
    case 'logout':
        session_destroy();
        header('Location: index.php?page=home');
        exit;

    default:
        http_response_code(404);
        echo "<h1>Page non trouvée</h1>";
        echo "<p>La page demandée (<strong>" . htmlspecialchars($page) . "</strong>) n'existe pas.</p>";
        break;
}