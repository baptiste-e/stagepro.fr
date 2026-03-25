<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Entreprise.php';
require_once __DIR__ . '/../Models/Offre.php';

class AdminController {
    
    public function dashboard() {
        // 1. Sécurité : Vérification flexible du rôle (role ou role_nom)
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        
        if (!isset($_SESSION['user']) || $role !== 'admin') {
            // Au lieu d'un die(), une redirection est plus élégante
            header('Location: index.php?page=login');
            exit;
        }

        // 2. Initialisation des modèles
        $userModel = new Utilisateur();
        $entrepriseModel = new Entreprise();
        $offreModel = new Offre();

        // 3. Récupération des statistiques réelles
        // Note : Assure-toi que ces méthodes existent dans tes fichiers Models !
        $stats = [
            'etudiants'   => $userModel->countByRole('etudiant'),
            'pilotes'     => $userModel->countByRole('pilote'),
            'entreprises' => $entrepriseModel->countAll(),
            'offres'      => $offreModel->countAll()
        ];

        $titre_page = "Tableau de Bord Administrateur | StagePro";

        // 4. Affichage
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/admin/dashboard.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}