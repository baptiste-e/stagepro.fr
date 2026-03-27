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

    private function getRole(): string {
        return strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
    }

    /**
     * Liste des candidatures
     * - étudiant : ses candidatures
     * - admin/pilote : toutes les candidatures
     */
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $role = $this->getRole();

        if (in_array($role, ['admin', 'pilote'], true)) {
            $candidatures = $this->model->findAllFull();
            $titre_page = "Gestion des candidatures | StagePro";
        } else {
            $userId = (int)$_SESSION['user']['id'];
            $candidatures = $this->model->findByEtudiant($userId);
            $titre_page = "Mes Candidatures | StagePro";
        }

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/candidatures/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Détail d'une candidature
     */
    public function show($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $candidature = $this->model->findByIdFull((int)$id);
        if (!$candidature) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        $role = $this->getRole();

        if ($role === 'etudiant' && (int)$candidature['utilisateur_id'] !== (int)$_SESSION['user']['id']) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        $titre_page = "Détail candidature | StagePro";

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
            $offreId = (int)($_POST['id_offre'] ?? 0);
            $lettre = htmlspecialchars($_POST['lm'] ?? '');
            $userId = (int)$_SESSION['user']['id'];

            $cvPath = null;
            if (!empty($_FILES['cv']['tmp_name'])) {
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                $cvPath = 'uploads/' . time() . '_' . basename($_FILES['cv']['name']);
                move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
            }

            $this->model->create($userId, $offreId, $cvPath, $lettre);
            header("Location: index.php?page=candidatures&status=applied");
            exit;
        }
    }

    /**
     * Mise à jour du statut (admin / pilote)
     */
    public function updateStatus($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $role = $this->getRole();
        if (!in_array($role, ['admin', 'pilote'], true)) {
            header('Location: index.php?page=home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $statut = $_POST['statut'] ?? 'en_attente';
            $this->model->updateStatut((int)$id, $statut);
        }

        header('Location: index.php?page=candidature-detail&id=' . (int)$id);
        exit;
    }

    /**
     * Annulation de candidature (étudiant uniquement)
     */
    public function cancel($id_candidature) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $role = $this->getRole();
        if ($role !== 'etudiant') {
            header('Location: index.php?page=candidatures');
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