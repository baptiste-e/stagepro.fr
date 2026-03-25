<?php
// app/Controllers/CandidatureController.php
require_once __DIR__ . '/../Models/Candidature.php';

class CandidatureController {
    private $model;

    public function __construct() {
        $this->model = new Candidature();
    }

    public function index() {
        if (!isset($_SESSION['user'])) header('Location: index.php?page=login');
        
        $userId = $_SESSION['user']['id'];
        $candidatures = $this->model->findByEtudiant($userId);
        $titre_page = "Mes Candidatures | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/candidatures/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Traite l'envoi du formulaire (Ancien traitement-candidature.php)
     */
    public function postuler() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $offreId = (int)$_POST['id_offre'];
            $lettre = $_POST['lm'] ?? '';
            $userId = $_SESSION['user']['id'];

            // Gestion simple du fichier CV
            $cvPath = null;
            if (!empty($_FILES['cv']['tmp_name'])) {
                $cvPath = 'uploads/' . time() . '_' . $_FILES['cv']['name'];
                move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
            }

            $this->model->create($userId, $offreId, $cvPath, $lettre);
            header("Location: index.php?page=offre-detail&id=" . $offreId);
            exit;
        }
    }
}