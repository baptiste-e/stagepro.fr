<?php
// app/Controllers/OffreController.php
require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Candidature.php';

class OffreController {
    private $model;

    public function __construct() {
        $this->model = new Offre();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $filters = [
            'titre'        => trim($_GET['titre'] ?? ''),
            'entreprise'   => trim($_GET['entreprise'] ?? ''),
            'competences'  => trim($_GET['competences'] ?? ''),
            'remuneration' => trim($_GET['remuneration'] ?? ''),
            'date_offre'   => trim($_GET['date_offre'] ?? ''),
            'date_debut'   => trim($_GET['date_debut'] ?? ''),
            'date_fin'     => trim($_GET['date_fin'] ?? '')
        ];

        $hasFilters = !empty(array_filter($filters, fn($value) => $value !== ''));
        $offres = $hasFilters ? $this->model->search($filters) : $this->model->findAll();

        $titre_page = "Offres de stage | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id) {
        $offre = $this->model->findById((int)$id);
        if (!$offre) {
            die("Offre introuvable.");
        }

        $maCandidature = null;

        // Cette méthode n'existe peut-être pas encore dans ton modèle Candidature.
        // On garde ici un garde-fou pour éviter de casser l'affichage.
        if (
            isset($_SESSION['user']) &&
            strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '') === 'etudiant'
        ) {
            $candModel = new Candidature();

            if (method_exists($candModel, 'findSpecific')) {
                $maCandidature = $candModel->findSpecific($_SESSION['user']['id'], $id);
            }
        }

        $titre_page = htmlspecialchars($offre['titre']) . " | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create($id = 0) {
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');

        if (!isset($_SESSION['user']) || $role === 'etudiant') {
            header('Location: index.php?page=login');
            exit;
        }

        $modeEdition = ((int)$id > 0);
        $offre = $modeEdition ? $this->model->findById((int)$id) : null;
        $entreprises = (new Entreprise())->findAll();

        $titre_page = $modeEdition ? "Modifier l'offre" : "Publier une offre";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=offres');
            exit;
        }

        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || $role === 'etudiant') {
            header('Location: index.php?page=login');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        $dateOffre = trim($_POST['date_offre'] ?? '');
        if ($dateOffre === '') {
            $dateOffre = date('Y-m-d');
        }

        $data = [
            'titre'         => htmlspecialchars(trim($_POST['titre'] ?? '')),
            'description'   => htmlspecialchars(trim($_POST['description'] ?? '')),
            'competences'   => htmlspecialchars(trim($_POST['competences'] ?? '')),
            'localite'      => htmlspecialchars(trim($_POST['localite'] ?? '')),
            'duree'         => htmlspecialchars(trim($_POST['duree'] ?? '')),
            'remuneration'  => ($_POST['remuneration'] ?? '') !== '' ? (float)$_POST['remuneration'] : null,
            'nb_places'     => (int)($_POST['nb_places'] ?? 1),
            'id_entreprise' => (int)($_POST['id_entreprise'] ?? 0),
            'date_offre'    => $dateOffre
        ];

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=offres');
        exit;
    }

    public function delete($id) {
        if ((int)$id <= 0) {
            $id = (int)($_POST['id'] ?? 0);
        }

        if ((int)$id > 0) {
            $this->model->delete((int)$id);
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