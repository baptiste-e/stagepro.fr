<?php
// app/Controllers/PiloteController.php
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

        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $roles, true)) {
            header('Location: index.php?page=home');
            exit;
        }
    }

    public function index()
    {
        // Seuls admin et pilote peuvent voir l'annuaire des pilotes
        $this->requireRoles(['admin', 'pilote']);

        $pilotes = $this->model->findByRole('pilote');
        $titre_page = "Annuaire des pilotes | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id)
    {
        // Seuls admin et pilote peuvent voir le détail d'un pilote
        $this->requireRoles(['admin', 'pilote']);

        $pilote = $this->model->findById($id);

        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $titre_page = "Profil Pilote : " . htmlspecialchars($pilote['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create()
    {
        // Seul l'admin peut créer un pilote
        $this->requireRoles(['admin']);

        $titre_page = "Ajouter un pilote | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}