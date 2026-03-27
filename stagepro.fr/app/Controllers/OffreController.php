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
        $offre = $this->model->findById((int)$id);
        if (!$offre) {
            die("Offre introuvable.");
        }

        $maCandidature = null;
        if (isset($_SESSION['user']) && strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '') === 'etudiant') {
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
        if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '') === 'etudiant') {
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
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'titre' => htmlspecialchars($_POST['titre'] ?? ''),
            'description' => htmlspecialchars($_POST['description'] ?? ''),
            'competences' => htmlspecialchars($_POST['competences'] ?? ''),
            'localite' => htmlspecialchars($_POST['localite'] ?? ''),
            'duree' => htmlspecialchars($_POST['duree'] ?? ''),
            'remuneration' => ($_POST['remuneration'] ?? '') !== '' ? (float)$_POST['remuneration'] : null,
            'nb_places' => (int)($_POST['nb_places'] ?? 1),
            'id_entreprise' => (int)($_POST['id_entreprise'] ?? 0)
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
        $totalOffres = $this->model->countAll();

        $topLocalite = !empty($statsLocalite) ? $statsLocalite[0] : null;
        $topEntreprise = null;
        $nbEntreprisesAvecOffres = 0;

        foreach ($statsEntreprise as $ligne) {
            if ((int)($ligne['nb'] ?? 0) > 0) {
                $nbEntreprisesAvecOffres++;

                if ($topEntreprise === null) {
                    $topEntreprise = $ligne;
                }
            }
        }

        $titre_page = "Statistiques | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/stats.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}