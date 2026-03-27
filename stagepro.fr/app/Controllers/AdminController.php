<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Offre.php';

class AdminController {
    private $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function dashboard() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        
        if (!isset($_SESSION['user']) || $role !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }

        $userModel = new Utilisateur();
        $entrepriseModel = new Entreprise();
        $offreModel = new Offre();

        $stats = [
            'etudiants'   => $userModel->countByRole('etudiant'),
            'pilotes'     => $userModel->countByRole('pilote'),
            'entreprises' => $entrepriseModel->countAll(),
            'offres'      => $offreModel->countAll()
        ];

        echo $this->twig->render('admin/dashboard.html.twig', [
            'stats' => $stats,
            'titre_page' => "Tableau de Bord Administrateur | StagePro"
        ]);
    }
}