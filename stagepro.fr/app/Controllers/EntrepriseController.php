<?php
// app/Controllers/EntrepriseController.php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Entreprise();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkAuth() {
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function index() {
        $entreprises = $this->model->findAll();
        foreach ($entreprises as &$entreprise) {
            $entreprise['nb_offres'] = $this->model->countOffresLiees((int)$entreprise['id']);
        }
        unset($entreprise);

        echo $this->twig->render('entreprises/liste.html.twig', [
            'entreprises' => $entreprises,
            'titre_page' => "Annuaire des Entreprises | StagePro"
        ]);
    }

    /**
     * UNE SEULE MÉTHODE SHOW ICI (Fusionnée avec les avis)
     */
    public function show($id) {
        $entreprise = $this->model->findById((int)$id);
        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }

        $entreprise['nb_offres'] = $this->model->countOffresLiees((int)$entreprise['id']);
        
        // On récupère les avis pour les passer à la vue (SFx 5)
        $evaluations = $this->model->getEvaluations((int)$id);

        echo $this->twig->render('entreprises/detail.html.twig', [
            'entreprise' => $entreprise,
            'evaluations' => $evaluations,
            'titre_page' => "Fiche " . $entreprise['nom'] . " | StagePro"
        ]);
    }

    public function create() {
        $this->checkAuth();
        echo $this->twig->render('entreprises/formulaire.html.twig', [
            'titre_page' => "Ajouter une entreprise | StagePro",
            'entreprise' => null
        ]);
    }

    public function edit($id) {
        $this->checkAuth();
        $entreprise = $this->model->findById((int)$id);
        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }
        echo $this->twig->render('entreprises/formulaire.html.twig', [
            'entreprise' => $entreprise,
            'titre_page' => "Modifier l'entreprise : " . $entreprise['nom']
        ]);
    }

    public function save() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create(
                trim($_POST['nom'] ?? ''),
                trim($_POST['description'] ?? ''),
                trim($_POST['email_contact'] ?? ''),
                trim($_POST['telephone_contact'] ?? '')
            );
            header('Location: index.php?page=entreprises&status=created');
            exit;
        }
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'email_contact' => trim($_POST['email_contact'] ?? ''),
                'telephone_contact' => trim($_POST['telephone_contact'] ?? '')
            ];
            $this->model->update($id, $data);
            header('Location: index.php?page=entreprise-detail&id=' . $id . '&status=updated');
            exit;
        }
    }

    public function delete() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) { $this->model->delete($id); }
            header('Location: index.php?page=entreprises&status=deleted');
            exit;
        }
    }

    public function evaluate($id) {
        $entreprise = $this->model->findById((int)$id);
        echo $this->twig->render('entreprises/evaluer.html.twig', [
            'entreprise' => $entreprise,
            'titre_page' => "Évaluer " . $entreprise['nom']
        ]);
    }

    public function saveEvaluation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eId = $_POST['entreprise_id'];
            $uId = $_SESSION['user']['id'];
            $note = $_POST['note'];
            $comm = $_POST['commentaire'];

            $this->model->addEvaluation($eId, $uId, $note, $comm);
            header("Location: index.php?page=entreprise-detail&id=" . $eId . "&status=evaluated");
            exit;
        }
    }
}