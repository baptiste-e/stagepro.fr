<?php
// app/Controllers/EtudiantController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class EtudiantController {
    private $model;

    public function __construct() {
        $this->model = new Utilisateur();
    }

    /**
     * Affiche l'annuaire des étudiants
     */
    public function index() {
        // On récupère uniquement les utilisateurs ayant le rôle 'etudiant'
        $etudiants = $this->model->findByRole('etudiant');
        $titre_page = "Annuaire des étudiants | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Affiche le profil détaillé d'un étudiant
     */
    public function show($id) {
        // On récupère l'étudiant précis par son ID
        $etudiant = $this->model->findById($id);

        if (!$etudiant) {
            // Si l'étudiant n'existe pas, on redirige vers la liste
            header('Location: index.php?page=etudiants');
            exit;
        }

        $titre_page = "Profil de " . htmlspecialchars($etudiant['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/detail.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Affiche le formulaire de création d'un étudiant
     */
    public function create() {
        // Sécurité optionnelle : vérifier si l'utilisateur est admin ou pilote
        // On utilise ?? pour donner une valeur vide par défaut si la clé n'existe pas
$role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';

if (!isset($_SESSION['user']) || $role === 'etudiant') {
    header('Location: index.php?page=home');
    exit;
}

        $titre_page = "Ajouter un étudiant | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/formulaire.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

} // Fin de la classe