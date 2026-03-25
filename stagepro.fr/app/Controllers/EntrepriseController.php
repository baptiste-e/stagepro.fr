<?php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;

    public function __construct() {
        $this->model = new Entreprise();
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
            die("Entreprise introuvable");
        }
        
        $titre_page = "Fiche " . $entreprise['nom'] . " | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function edit($id) {
        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $entreprise = $this->model->findById($id);

        if (!$entreprise) {
            die("Entreprise introuvable.");
        }

        $titre_page = "Modifier une entreprise | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=entreprises');
            exit;
        }

        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'email_contact' => trim($_POST['email_contact'] ?? ''),
            'telephone_contact' => trim($_POST['telephone_contact'] ?? '')
        ];

        $this->model->update($id, $data);

        $_SESSION['success'] = "Entreprise modifiée avec succès.";
        header('Location: index.php?page=entreprise-detail&id=' . $id);
        exit;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=entreprises');
            exit;
        }

        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?page=entreprises');
            exit;
        }

        $nbOffres = $this->model->countOffresLiees($id);

        if ($nbOffres > 0) {
            $_SESSION['error'] = "Impossible de supprimer cette entreprise : $nbOffres offre(s) y sont encore rattachée(s).";
            header('Location: index.php?page=entreprise-detail&id=' . $id);
            exit;
        }

        $this->model->delete($id);

        $_SESSION['success'] = "Entreprise supprimée avec succès.";
        header('Location: index.php?page=entreprises');
        exit;
    }
}