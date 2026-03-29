<?php
// app/Controllers/OffreController.php
require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Candidature.php';

class OffreController {
    private $model;
    private $twig;

    /**
     * Le constructeur initialise le modèle et reçoit l'instance Twig
     */
    public function __construct($twig) {
        $this->model = new Offre();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Liste des offres avec système de filtrage
     */
    public function index() {
        $filters = [
            'titre' => trim($_GET['titre'] ?? ''),
            'entreprise' => trim($_GET['entreprise'] ?? ''),
            'competences' => trim($_GET['competences'] ?? ''),
            'remuneration' => trim($_GET['remuneration'] ?? '')
        ];

        // On filtre les résultats seulement si au moins un champ est rempli
        $hasFilters = !empty(array_filter($filters));
        $offres = $hasFilters ? $this->model->search($filters) : $this->model->findAll();
        
        echo $this->twig->render('offres/liste.html.twig', [
            'offres' => $offres,
            'filters' => $filters,
            'titre_page' => "Offres de stage | StagePro"
        ]);
    }

    /**
     * Affiche le détail d'une offre et vérifie si l'étudiant a déjà postulé
     */
    public function show($id) {
        $offre = $this->model->findById((int)$id);
        if (!$offre) { 
            header('Location: index.php?page=offres');
            exit;
        }

        $maCandidature = null;
        // On récupère le rôle de l'utilisateur (insensible à la casse)
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        
        if (isset($_SESSION['user']) && $role === 'etudiant') {
            $candModel = new Candidature();
            // Sécurité : on vérifie que la méthode de recherche de candidature existe
            if (method_exists($candModel, 'findSpecific')) {
                $maCandidature = $candModel->findSpecific($_SESSION['user']['id'], (int)$id);
            }
        }

        echo $this->twig->render('offres/detail.html.twig', [
            'offre' => $offre,
            'maCandidature' => $maCandidature,
            'titre_page' => htmlspecialchars($offre['titre']) . " | StagePro"
        ]);
    }

    /**
     * Formulaire de création ou d'édition (réservé Admin/Pilote)
     */
    public function create($id = 0) {
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        
        // Seuls l'admin et le pilote peuvent accéder à la gestion des offres
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $modeEdition = ((int)$id > 0);
        $offre = $modeEdition ? $this->model->findById((int)$id) : null;
        $entreprises = (new Entreprise())->findAll();

        echo $this->twig->render('offres/formulaire.html.twig', [
            'modeEdition' => $modeEdition,
            'offre' => $offre,
            'entreprises' => $entreprises,
            'titre_page' => $modeEdition ? "Modifier l'offre" : "Publier une offre"
        ]);
    }

    /**
     * Sauvegarde les données (Insert ou Update)
     */
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=offres');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        
        // Construction des données sécurisées (fusion des logiques)
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

        header('Location: index.php?page=offres&status=success');
        exit;
    }

    /**
     * Supprime une offre (réservé Admin/Pilote)
     */
    public function delete($id) {
        $id_to_delete = ((int)$id > 0) ? (int)$id : (int)($_POST['id'] ?? 0);

        if ($id_to_delete > 0) {
            $this->model->delete($id_to_delete);
        }

        header('Location: index.php?page=offres&status=deleted');
        exit;
    }

    /**
     * Statistiques détaillées des offres
     */
    public function stats() {
        $statsLocalite = $this->model->getStatsByLocalite();
        $statsEntreprise = $this->model->getStatsByEntreprise();
        $totalOffres = $this->model->countAll();

        // Calcul du top localité et top entreprise
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

        echo $this->twig->render('offres/stats.html.twig', [
            'statsLocalite' => $statsLocalite,
            'statsEntreprise' => $statsEntreprise,
            'totalOffres' => $totalOffres,
            'topLocalite' => $topLocalite,
            'topEntreprise' => $topEntreprise,
            'nbEntreprisesAvecOffres' => $nbEntreprisesAvecOffres,
            'titre_page' => "Statistiques | StagePro"
        ]);
    }
}