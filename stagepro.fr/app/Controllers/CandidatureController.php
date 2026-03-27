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
     * Affiche la liste des candidatures selon le rôle :
     * - étudiant : ses candidatures
     * - pilote : candidatures de ses étudiants
     * - admin : toutes les candidatures
     */
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'] ?? '';

        if ($role === 'etudiant') {
            $candidatures = $this->model->findByEtudiant($userId);
            $titre_page = "Mes Candidatures | StagePro";
        } elseif ($role === 'pilote') {
            $candidatures = $this->model->findByPilote($userId);
            $titre_page = "Candidatures de mes étudiants | StagePro";
        } elseif ($role === 'admin') {
            $candidatures = $this->model->findAll();
            $titre_page = "Toutes les candidatures | StagePro";
        } else {
            header('Location: index.php?page=home');
            exit;
        }

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
        $role = $_SESSION['user']['role'] ?? '';
        $userId = (int) $_SESSION['user']['id'];

        if (!$candidature) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        // Étudiant : seulement sa propre candidature
        if ($role === 'etudiant' && (int)$candidature['utilisateur_id'] !== $userId) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        // Pilote : seulement les candidatures de ses étudiants
        if ($role === 'pilote') {
            $listePilote = $this->model->findByPilote($userId);
            $idsAutorises = array_column($listePilote, 'id');

            if (!in_array((int)$id, array_map('intval', $idsAutorises), true)) {
                header('Location: index.php?page=candidatures');
                exit;
            }
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
            $offreId = (int) ($_POST['id_offre'] ?? 0);
            $lettre = htmlspecialchars($_POST['lm'] ?? '');
            $userId = (int) $_SESSION['user']['id'];

            // empêcher double candidature
            $existing = $this->model->findSpecific($userId, $offreId);
            if ($existing) {
                header("Location: index.php?page=candidatures&status=already_exists");
                exit;
            }

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
     * Annulation de candidature
     */
    public function cancel($id_candidature) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];
        $idCand = (int) $id_candidature;

        if ($idCand > 0) {
            $this->model->deleteByIdentifiers($idCand, $userId);
        }

        header("Location: index.php?page=candidatures&status=canceled");
        exit;
    }
}