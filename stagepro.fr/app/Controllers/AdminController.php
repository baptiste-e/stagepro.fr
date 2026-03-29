<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Offre.php';

class AdminController
{
    private $twig;

    /**
     * Le constructeur reçoit Twig depuis l'index.php
     */
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    /**
     * Méthode de sécurité interne (issue du travail de tes collègues)
     */
    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérification stricte du rôle Admin
     */
    private function requireAdmin(): void
    {
        $this->startSessionIfNeeded();

        // On vérifie les deux clés possibles (role ou role_nom)
        $role = $_SESSION['user']['role'] ?? $_SESSION['user']['role_nom'] ?? '';
        $role = strtolower(trim($role));

        if (!isset($_SESSION['user']) || $role !== 'admin') {
            // Optionnel : On peut vider la session si tentative d'intrusion
            // session_unset(); 
            // session_destroy();
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Affichage du Dashboard avec Twig
     */
    public function dashboard()
    {
        // 1. On sécurise l'accès
        $this->requireAdmin();

        // 2. Initialisation des modèles
        $userModel = new Utilisateur();
        $entrepriseModel = new Entreprise();
        $offreModel = new Offre();

        // 3. Récupération des statistiques
        $stats = [
            'etudiants'   => $userModel->countByRole('etudiant'),
            'pilotes'     => $userModel->countByRole('pilote'),
            'entreprises' => $entrepriseModel->countAll(),
            'offres'      => $offreModel->countAll()
        ];

        // 4. Rendu Twig (Fusion de la logique et du moteur)
        echo $this->twig->render('admin/dashboard.html.twig', [
            'stats' => $stats,
            'titre_page' => "Tableau de Bord Administrateur | StagePro"
        ]);
    }
}