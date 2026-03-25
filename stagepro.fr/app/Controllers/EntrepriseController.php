<?php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController
{
    private $model;

    public function __construct()
    {
        $this->model = new Entreprise();
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
            session_unset();
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function index()
    {
        $entreprises = $this->model->findAll();
        $titre_page = "Annuaire des entreprises | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id)
    {
        $entreprise = $this->model->findById($id);

        if (!$entreprise) {
            die("Entreprise introuvable.");
        }

        $titre_page = htmlspecialchars($entreprise['nom']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create()
    {
        $this->requireRoles(['admin', 'pilote']);

        $titre_page = "Créer une entreprise | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function save()
    {
        $this->requireRoles(['admin', 'pilote']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=entreprises');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $email = trim($_POST['email_contact'] ?? '');
        $telephone = trim($_POST['telephone_contact'] ?? '');

        if ($nom === '') {
            die("Le nom de l'entreprise est obligatoire.");
        }

        $this->model->create($nom, $description, $email, $telephone);

        header('Location: index.php?page=entreprises');
        exit;
    }
}