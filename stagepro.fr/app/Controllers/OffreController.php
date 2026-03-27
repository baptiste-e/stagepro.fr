<?php
// app/Controllers/OffreController.php
require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Candidature.php';

class OffreController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Offre();
        $this->twig = $twig;
    }

    /**
     * Liste des offres avec filtres
     */
    public function index() {
        $filters = [
            'titre' => trim($_GET['titre'] ?? ''),
            'entreprise' => trim($_GET['entreprise'] ?? ''),
            'competences' => trim($_GET['competences'] ?? ''),
            'remuneration' => trim($_GET['remuneration'] ?? '')
        ];

        $hasFilters = !empty(array_filter($filters));
        $offres = $hasFilters ? $this->model->search($filters) : $this->model->findAll();
        
        echo $this->twig->render('offres/liste.html.twig', [
            'offres' => $offres,
            'filters' => $filters,
            'titre_page' => "Offres de stage | StagePro"
        ]);
    }

    /**
     * Détail d'une offre
     */
    public function show($id) {
        $offre = $this->model->findById($id);
        if (!$offre) { 
            header('Location: index.php?page=offres');
            exit;
        }

        $maCandidature = null;
        if (isset($_SESSION['user']) && strtolower($_SESSION['user']['role_nom'] ?? '') === 'etudiant') {
            $candModel = new Candidature();
            $maCandidature = $candModel->findSpecific($_SESSION['user']['id'], $id);
        }

        echo $this->twig->render('offres/detail.html.twig', [
            'offre' => $offre,
            'maCandidature' => $maCandidature,
            'titre_page' => $offre['titre'] . " | StagePro"
        ]);
    }

    /**
     * Formulaire Création / Édition (La méthode qui te manquait !)
     */
    public function create($id = 0) {
        // Sécurité : Seuls Admin et Pilote peuvent accéder
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $modeEdition = ($id > 0);
        $offre = $modeEdition ? $this->model->findById($id) : null;
        $entreprises = (new Entreprise())->findAll();

        echo $this->twig->render('offres/formulaire.html.twig', [
            'modeEdition' => $modeEdition,
            'offre' => $offre,
            'entreprises' => $entreprises,
            'titre_page' => $modeEdition ? "Modifier l'offre" : "Publier une offre"
        ]);
    }

    /**
     * Enregistrement en base de données
     */
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=offres');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'titre' => htmlspecialchars($_POST['titre']),
            'description' => htmlspecialchars($_POST['description']),
            'competences' => htmlspecialchars($_POST['competences']),
            'localite' => htmlspecialchars($_POST['localite']),
            'duree' => htmlspecialchars($_POST['duree']),
            'remuneration' => !empty($_POST['remuneration']) ? $_POST['remuneration'] : null,
            'nb_places' => (int)$_POST['nb_places'],
            'id_entreprise' => (int)$_POST['id_entreprise']
        ];

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=offres&status=success');
        exit;
    }

    /**
     * Suppression d'une offre
     */
    public function delete($id) {
        // On récupère l'ID soit par l'argument, soit par le POST
        $id_to_delete = ($id > 0) ? $id : (int)($_POST['id'] ?? 0);

        if ($id_to_delete > 0) {
            $this->model->delete($id_to_delete);
        }

        header('Location: index.php?page=offres&msg=deleted');
        exit;
    }

    /**
     * Statistiques
     */
    public function stats() {
        echo $this->twig->render('offres/stats.html.twig', [
            'statsLocalite' => $this->model->getStatsByLocalite(),
            'statsEntreprise' => $this->model->getStatsByEntreprise(),
            'totalOffres' => $this->model->countAll(),
            'titre_page' => "Statistiques | StagePro"
        ]);
    }
}