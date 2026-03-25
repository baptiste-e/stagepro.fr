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

public function save() {
        // Sécurité : Seul un admin ou un pilote peut créer/modifier un étudiant
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=etudiants');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => 3 // ID correspondant au rôle 'etudiant'
        ];

        // Hachage du mot de passe
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            // Mot de passe par défaut à la création si le champ est vide
            $data['mot_de_passe'] = password_hash('Cesi2026!', PASSWORD_DEFAULT);
        }

        // Utilisation du modèle Utilisateur (qui a déjà create et update)
        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=etudiants');
        exit;
    }


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


} // Fin de la classe