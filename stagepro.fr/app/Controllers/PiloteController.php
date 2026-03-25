<?php
require_once __DIR__ . '/../Models/Utilisateur.php';

class PiloteController
{
    private $model;

    public function __construct()
    {
        $this->model = new Utilisateur();
    }

    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function requireRoles(array $roles): void
    {
        $this->startSessionIfNeeded();

        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? null;

        if (!isset($_SESSION['user']) || !in_array($role, $roles, true)) {
            die('Accès refusé.');
        }
    }

    /**
     * Affiche l'annuaire des pilotes
     */
    public function index()
    {
        $this->requireRoles(['admin', 'pilote']);

        $pilotes = $this->model->findByRole('pilote');
        $titre_page = "Annuaire des pilotes | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Affiche le profil détaillé d'un pilote
     */
    public function show($id)
    {
        $this->requireRoles(['admin', 'pilote']);

        $pilote = $this->model->findById($id);

        if (!$pilote) {
            die('Pilote introuvable.');
        }

        $titre_page = "Profil Pilote : " . htmlspecialchars($pilote['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $this->requireRoles(['admin']);

        $titre_page = "Ajouter un pilote | StagePro";
        $modeEdition = false;

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * TRAITEMENT : Enregistre ou modifie un pilote
     */
    public function save()
    {
        $this->requireRoles(['admin']);

        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => 2 // ID Pilote
        ];

        // Hachage du mot de passe
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            // Mot de passe par défaut à la création si vide
            $data['mot_de_passe'] = password_hash('StagePro2026', PASSWORD_DEFAULT);
        }

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=pilotes');
        exit;
    }

    /**
     * SUPPRESSION : Retire un pilote de la base
     */
    public function delete()
    {
        $this->requireRoles(['admin']);

        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        header('Location: index.php?page=pilotes&message=deleted');
        exit;
    }
}