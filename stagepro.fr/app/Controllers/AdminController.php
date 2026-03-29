<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Offre.php';

class AdminController
{
    private $twig;

    /**
     * Le constructeur reçoit l'instance Twig depuis l'index.php
     */
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    /**
     * Démarre la session si elle n'est pas déjà active
     */
    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérification stricte du rôle Admin pour sécuriser la page
     */
    private function requireAdmin(): void
    {
        $this->startSessionIfNeeded();

        // On récupère le rôle peu importe le nom de la clé en session
        $role = $_SESSION['user']['role'] ?? $_SESSION['user']['role_nom'] ?? '';
        $role = strtolower(trim($role));

        if (!isset($_SESSION['user']) || $role !== 'admin') {
            // Sécurité : on détruit la session en cas de tentative d'accès illégitime
            session_unset();
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Affiche le tableau de bord administratif
     */
    public function dashboard()
    {
        // 1. On vérifie les droits d'accès
        $this->requireAdmin();

        // 2. Instanciation des modèles pour récupérer les données
        $userModel = new Utilisateur();
        $entrepriseModel = new Entreprise();
        $offreModel = new Offre();

        // 3. Préparation des statistiques pour la vue
        $stats = [
            'etudiants'   => $userModel->countByRole('etudiant'),
            'pilotes'     => $userModel->countByRole('pilote'),
            'entreprises' => $entrepriseModel->countAll(),
            'offres'      => $offreModel->countAll()
        ];

        // 4. Rendu de la vue Twig (plus besoin d'include header/footer)
        echo $this->twig->render('admin/dashboard.html.twig', [
            'stats' => $stats,
            'titre_page' => "Console d'administration | StagePro"
        ]);
    }
}