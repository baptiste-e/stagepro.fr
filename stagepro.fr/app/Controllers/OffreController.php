<?php
// app/Controllers/OffreController.php
require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Candidature.php';

class OffreController {
    private $model;

    public function __construct() {
        $this->model = new Offre();
    }

    public function index() {
        $filters = [
            'titre' => trim($_GET['titre'] ?? ''),
            'entreprise' => trim($_GET['entreprise'] ?? ''),
            'competences' => trim($_GET['competences'] ?? ''),
            'remuneration' => trim($_GET['remuneration'] ?? '')
        ];

        $hasFilters = !empty(array_filter($filters));
        $offres = $hasFilters ? $this->model->search($filters) : $this->model->findAll();
        
        $titre_page = "Offres de stage | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id) {
        $offre = $this->model->findById($id);
        if (!$offre) {
            die("Offre introuvable.");
        }

        $maCandidature = null;
        if (isset($_SESSION['user']) && strtolower($_SESSION['user']['role_nom'] ?? '') === 'etudiant') {
            $candModel = new Candidature();
            $maCandidature = $candModel->findSpecific($_SESSION['user']['id'], $id);
        }

        $titre_page = htmlspecialchars($offre['titre']) . " | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create($id = 0) {
        if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role_nom'] ?? '') === 'etudiant') {
            header('Location: index.php?page=login');
            exit;
        }

        $modeEdition = ($id > 0);
        $offre = $modeEdition ? $this->model->findById($id) : null;
        $entreprises = (new Entreprise())->findAll();

        $titre_page = $modeEdition ? "Modifier l'offre" : "Publier une offre";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'titre' => htmlspecialchars($_POST['titre']),
            'description' => htmlspecialchars($_POST['description']),
            'competences' => htmlspecialchars($_POST['competences']),
            'localite' => htmlspecialchars($_POST['localite']),
            'duree' => htmlspecialchars($_POST['duree']),
            'remuneration' => $_POST['remuneration'] ?: null,
            'nb_places' => (int)$_POST['nb_places'],
            'id_entreprise' => (int)$_POST['id_entreprise']
        ];

        $id > 0 ? $this->model->update($id, $data) : $this->model->create($data);
        header('Location: index.php?page=offres');
        exit;
    }

    public function delete($id) {
        // Correction : Récupération de l'ID en POST si non présent en GET
        if ($id <= 0) {
            $id = (int)($_POST['id'] ?? 0);
        }

        if ($id > 0) {
            $this->model->delete($id);
        }
        header('Location: index.php?page=offres&msg=deleted');
        exit;
    }

    public function stats() {
        $statsLocalite = $this->model->getStatsByLocalite();
        $statsEntreprise = $this->model->getStatsByEntreprise();
        $titre_page = "Statistiques | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/stats.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}