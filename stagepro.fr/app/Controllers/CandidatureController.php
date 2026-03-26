<?php
// app/Controllers/CandidatureController.php
require_once __DIR__ . '/../Models/Candidature.php';

class CandidatureController {
    private $model;

    public function __construct() {
        $this->model = new Candidature();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Affiche la liste des candidatures de l'étudiant
     */
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        
        $userId = $_SESSION['user']['id'];
        $candidatures = $this->model->findByEtudiant($userId);
        $titre_page = "Mes Candidatures | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/candidatures/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Affiche le détail d'une candidature précise
     */
    public function show($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $candidature = $this->model->findByIdFull((int)$id);

        // Sécurité : l'étudiant ne peut pas voir la candidature d'un autre
        if (!$candidature || $candidature['utilisateur_id'] != $_SESSION['user']['id']) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        $titre_page = "Détail de ma candidature | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/candidatures/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Formulaire pour postuler
     */
    public function postuler() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $offreId = (int)$_POST['id_offre'];
            $lettre = htmlspecialchars($_POST['lm'] ?? '');
            $userId = $_SESSION['user']['id'];

            $cvPath = null;
            if (!empty($_FILES['cv']['tmp_name'])) {
                if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }
                $cvPath = 'uploads/' . time() . '_' . basename($_FILES['cv']['name']);
                move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
            }

            $this->model->create($userId, $offreId, $cvPath, $lettre);
            header("Location: index.php?page=candidatures&status=applied");
            exit;
        }
    }

    /**
     * Annulation de candidature
     */
    public function cancel($id_candidature) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];
        $id_cand = (int)$id_candidature;

        if ($id_cand > 0) {
            $this->model->deleteByIdentifiers($id_cand, $userId);
        }

        header("Location: index.php?page=candidatures&status=canceled");
        exit;
    }
}