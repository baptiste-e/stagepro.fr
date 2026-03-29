<?php
// app/Controllers/CandidatureController.php
require_once __DIR__ . '/../Models/Candidature.php';

class CandidatureController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Candidature();
        $this->twig = $twig;
        
        // La session est normalement démarrée dans index.php, 
        // mais on garde une sécurité si besoin.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Retourne le rôle de l'utilisateur connecté en minuscules
     */
    private function getRole(): string {
        return strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
    }

    /**
     * Liste des candidatures
     * - Étudiant : voit uniquement les siennes
     * - Admin/Pilote : voient toutes les candidatures du système
     */
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $role = $this->getRole();
        $userId = (int)$_SESSION['user']['id'];

        if (in_array($role, ['admin', 'pilote'], true)) {
            $candidatures = $this->model->findAllFull();
            $titre_page = "Gestion des candidatures | StagePro";
        } else {
            $candidatures = $this->model->findByEtudiant($userId);
            $titre_page = "Mes Candidatures | StagePro";
        }

        echo $this->twig->render('candidatures/liste.html.twig', [
            'candidatures' => $candidatures,
            'role' => $role,
            'titre_page' => $titre_page
        ]);
    }

    /**
     * Détail d'une candidature précise
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

        // Sécurité : un étudiant ne peut pas voir la candidature d'un autre
        if ($role === 'etudiant' && (int)$candidature['utilisateur_id'] !== (int)$_SESSION['user']['id']) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        echo $this->twig->render('candidatures/detail.html.twig', [
            'candidature' => $candidature,
            'role' => $role,
            'titre_page' => "Détail candidature | StagePro"
        ]);
    }

    /**
     * Traitement de la postulation (Formulaire POST)
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

            // Gestion de l'upload du CV
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
     * Mise à jour du statut (Acceptée, Refusée, etc.) - Réservé Admin/Pilote
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

        header('Location: index.php?page=candidature-detail&id=' . (int)$id . '&status=updated');
        exit;
    }

    /**
     * Annulation d'une candidature par l'étudiant
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