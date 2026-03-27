<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Offre.php';

class AdminController
{
    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function requireAdmin(): void
    {
        $this->startSessionIfNeeded();

        $role = $_SESSION['user']['role'] ?? $_SESSION['user']['role_nom'] ?? '';
        $role = strtolower(trim($role));

        if (!isset($_SESSION['user']) || $role !== 'admin') {
            session_unset();
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();

        $userModel = new Utilisateur();
        $entrepriseModel = new Entreprise();
        $offreModel = new Offre();

        $stats = [
            'etudiants'   => $userModel->countByRole('etudiant'),
            'pilotes'     => $userModel->countByRole('pilote'),
            'entreprises' => $entrepriseModel->countAll(),
            'offres'      => $offreModel->countAll()
        ];

        $titre_page = "Tableau de Bord Administrateur | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/admin/dashboard.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}