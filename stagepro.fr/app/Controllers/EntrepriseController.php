<?php
// app/Controllers/EntrepriseController.php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;

    public function __construct() {
        $this->model = new Entreprise();
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
    }

    /**
     * Vérifie si l'utilisateur est connecté et autorisé
     */
    private function checkAuth() {
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function index() {
        $entreprises = $this->model->findAll();
        $titre_page = "Annuaire des Entreprises | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id) {
        $entreprise = $this->model->findById($id);
        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }
        
        $titre_page = "Fiche " . htmlspecialchars($entreprise['nom']) . " | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create() {
        $this->checkAuth();
        $titre_page = "Ajouter une entreprise | StagePro";
        // $entreprise reste vide pour le mode création
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function edit($id) {
        $this->checkAuth();
        $entreprise = $this->model->findById($id);

        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }

        $titre_page = "Modifier l'entreprise : " . htmlspecialchars($entreprise['nom']);

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function save() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create(
                trim($_POST['nom'] ?? ''),
                trim($_POST['description'] ?? ''),
                trim($_POST['email_contact'] ?? ''),
                trim($_POST['telephone_contact'] ?? '')
            );
            header('Location: index.php?page=entreprises&status=created');
            exit;
        }
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'email_contact' => trim($_POST['email_contact'] ?? ''),
                'telephone_contact' => trim($_POST['telephone_contact'] ?? '')
            ];

            $this->model->update($id, $data);
            header('Location: index.php?page=entreprise-detail&id=' . $id . '&status=updated');
            exit;
        }
    }

    public function delete() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->model->delete($id);
            }
            header('Location: index.php?page=entreprises&status=deleted');
            exit;
        }
    }
}