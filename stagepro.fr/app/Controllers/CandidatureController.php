<?php
// app/Controllers/CandidatureController.php
require_once __DIR__ . '/../Models/Candidature.php';

class CandidatureController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Candidature();
        $this->twig = $twig;
        
        // Sécurité : démarrage de la session si nécessaire
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

        // -----------------------------
        // PAGINATION SQL : 6 candidatures par page
        // -----------------------------
        $candidaturesParPage = 6;
        $pageActuelle = max(1, (int)($_GET['pagination'] ?? 1));

        if (in_array($role, ['admin', 'pilote'], true)) {
            $totalCandidatures = $this->model->countAllFull();
            $titre_page = "Gestion des candidatures | StagePro";
        } else {
            $totalCandidatures = $this->model->countByEtudiant($userId);
            $titre_page = "Mes Candidatures | StagePro";
        }

        $totalPages = max(1, (int)ceil($totalCandidatures / $candidaturesParPage));

        if ($pageActuelle > $totalPages) {
            $pageActuelle = $totalPages;
        }

        $offset = ($pageActuelle - 1) * $candidaturesParPage;

        if (in_array($role, ['admin', 'pilote'], true)) {
            $candidatures = $this->model->findAllFullPaginated($candidaturesParPage, $offset);
        } else {
            $candidatures = $this->model->findByEtudiantPaginated($userId, $candidaturesParPage, $offset);
        }

        echo $this->twig->render('candidatures/liste.html.twig', [
            'candidatures' => $candidatures,
            'role' => $role,

            // Variables pour la pagination dans Twig
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'routePagination' => 'candidatures',

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

        // Sécurité : un étudiant ne peut pas voir la candidature d'un autre via l'URL
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
            Csrf::check();
            $offreId = (int)($_POST['id_offre'] ?? 0);
            $lettre = htmlspecialchars($_POST['lm'] ?? '');
            $userId = (int)$_SESSION['user']['id'];

            // Gestion de l'upload du CV : PDF uniquement
$cvPath = null;

if (!empty($_FILES['cv']['tmp_name'])) {
    $extension = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($_FILES['cv']['tmp_name']);

    if ($extension !== 'pdf' || $mime !== 'application/pdf') {
        die("Erreur : le CV doit être un fichier PDF.");
    }

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $cvPath = 'uploads/' . time() . '_' . basename($_FILES['cv']['name']);
    move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
}

            $this->model->create($userId, $offreId, $cvPath, $lettre);
            header("Location: /candidatures?status=applied");
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
            Csrf::check();
            $statut = $_POST['statut'] ?? 'en_attente';
            $this->model->updateStatut((int)$id, $statut);
        }

        header('Location: index.php?page=candidature-detail&id=' . (int)$id . '&status=updated');
        exit;
    }

    /**
     * Annulation d'une candidature par l'étudiant
     */
   public function cancel() {
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $role = $this->getRole();
    if ($role !== 'etudiant') {
        header('Location: index.php?page=candidatures');
        exit;
    }

    // ✅ Vérification CSRF
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Csrf::check();

        $userId = (int)$_SESSION['user']['id'];
        $id_cand = (int)($_POST['id'] ?? 0);

        if ($id_cand > 0) {
            // On vérifie que l'étudiant supprime SA propre candidature
            $this->model->deleteByIdentifiers($id_cand, $userId);
        }
    }

    header("Location: index.php?page=candidatures&status=canceled");
    exit;
}
}