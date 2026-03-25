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
        $etudiant = $this->model->findById($id);
        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }
        $titre_page = "Profil de " . htmlspecialchars($etudiant['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/detail.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Formulaire de création
     */
    public function create() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || $role === 'etudiant') {
            header('Location: index.php?page=home');
            exit;
        }
        $titre_page = "Ajouter un étudiant | StagePro";
        $modeEdition = false;

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/formulaire.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Formulaire de modification
     */
    public function edit($id) {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }

        $etudiant = $this->model->findById($id);
        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }

        $titre_page = "Modifier l'étudiant | StagePro";
        $modeEdition = true;

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/etudiants/formulaire.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Sauvegarde (Create ou Update)
     */
    public function save() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => 3 
        ];

        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            $data['mot_de_passe'] = password_hash('Cesi2026!', PASSWORD_DEFAULT);
        }

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=etudiants');
        exit;
    }

    /**
     * Suppression
     */
    public function delete() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            die("Accès refusé.");
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
        }
        header('Location: index.php?page=etudiants&message=deleted');
        exit;
    }
}