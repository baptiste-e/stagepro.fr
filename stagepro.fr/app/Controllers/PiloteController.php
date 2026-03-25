<?php
// app/Controllers/PiloteController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class PiloteController {
    private $model;

    public function __construct() {
        $this->model = new Utilisateur();
    }

    public function index() {
        $pilotes = $this->model->findByRole('pilote');
        $titre_page = "Annuaire des pilotes | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id) {
        $pilote = $this->model->findById($id);
        
        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $titre_page = "Profil Pilote : " . htmlspecialchars($pilote['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create() {
        // Sécurité : Seul l'admin peut créer un pilote
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || $role !== 'admin') {
            header('Location: index.php?page=home');
            exit;
        }

        $titre_page = "Ajouter un pilote | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/formulaire.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }
} // <--- C'EST CETTE ACCOLADE QUI MANQUAIT SUREMENT !