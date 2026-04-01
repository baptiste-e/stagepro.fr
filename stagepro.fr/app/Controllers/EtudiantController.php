<?php
// app/Controllers/EtudiantController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Role.php';
// CORRECTION : Ajout de l'import du modèle Candidature pour l'affichage du profil
require_once __DIR__ . '/../Models/Candidature.php';

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
     * Affiche le profil détaillé d'un étudiant avec ses candidatures
     */
    public function show($id) {
        // 1. Récupération des informations de l'étudiant
        $etudiant = $this->model->findById((int)$id);

        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }

        // 2. CORRECTION : Récupération des candidatures liées à cet étudiant
        $candidatureModel = new Candidature();
        $candidatures = $candidatureModel->findByEtudiant((int)$id);

        // 3. Envoi des données à la vue
        echo $this->twig->render('etudiants/detail.html.twig', [
            'etudiant' => $etudiant,
            'candidatures' => $candidatures, // Variable désormais disponible pour la boucle Twig
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
     * Sauvegarde (Création ou Mise à jour)
     */
    public function save() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';

        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        $id = (int)($_POST['id'] ?? 0);

        // Récupération du rôle étudiant pour l'ID de rôle correct
        $roleEtudiant = $this->roleModel->findByNom('etudiant');
        if (!$roleEtudiant) {
            die("Erreur critique : Le rôle 'etudiant' n'existe pas.");
        }

        $data = [
            'nom'    => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom' => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'  => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => (int)$roleEtudiant['id']
        ];

        // Hachage du mot de passe
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            // Mot de passe par défaut pour les nouveaux arrivants
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
     * Suppression d'un compte étudiant
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