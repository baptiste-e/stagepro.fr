<?php
// app/Controllers/EtudiantController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Role.php';

class EtudiantController {
    private $model;
    private $roleModel;
    private $twig;

    /**
     * Le constructeur initialise les modèles et l'instance Twig
     */
    public function __construct($twig) {
        $this->model = new Utilisateur();
        $this->roleModel = new Role();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Affiche l'annuaire des étudiants
     */
    public function index() {
        $etudiants = $this->model->findByRole('etudiant');
        
        echo $this->twig->render('etudiants/liste.html.twig', [
            'etudiants' => $etudiants,
            'titre_page' => "Annuaire des étudiants | StagePro"
        ]);
    }

    /**
     * Affiche le profil détaillé d'un étudiant
     */
    public function show($id) {
        $etudiant = $this->model->findById((int)$id);

        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }

        echo $this->twig->render('etudiants/detail.html.twig', [
            'etudiant' => $etudiant,
            'titre_page' => "Profil de " . $etudiant['nom'] . " | StagePro"
        ]);
    }

    /**
     * Formulaire de création (réservé Admin/Pilote)
     */
    public function create() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';

        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }

        echo $this->twig->render('etudiants/formulaire.html.twig', [
            'titre_page' => "Ajouter un étudiant | StagePro",
            'etudiant' => null,
            'modeEdition' => false
        ]);
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

        $etudiant = $this->model->findById((int)$id);

        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }

        echo $this->twig->render('etudiants/formulaire.html.twig', [
            'etudiant' => $etudiant,
            'modeEdition' => true,
            'titre_page' => "Modifier l'étudiant | StagePro"
        ]);
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

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        $id = (int)($_POST['id'] ?? 0);

        // Récupération dynamique du rôle depuis le modèle Role
        $roleEtudiant = $this->roleModel->findByNom('etudiant');
        if (!$roleEtudiant) {
            die("Erreur critique : Le rôle 'etudiant' n'existe pas en base de données.");
        }

        $data = [
            'nom'    => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom' => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'  => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => (int)$roleEtudiant['id']
        ];

        // Gestion du mot de passe (si fourni ou nouveau compte)
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            // Mot de passe par défaut pour les nouveaux comptes
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
     * Suppression d'un étudiant (via POST uniquement)
     */
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

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