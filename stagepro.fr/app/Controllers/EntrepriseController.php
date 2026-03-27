<?php
// app/Controllers/EntrepriseController.php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Entreprise();
        $this->twig = $twig;
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
        echo $this->twig->render('entreprises/liste.html.twig', [
            'entreprises' => $entreprises,
            'titre_page' => "Annuaire des Entreprises | StagePro"
        ]);
    }

    public function show($id) {
        $entreprise = $this->model->findById($id);
        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }
        
        echo $this->twig->render('entreprises/detail.html.twig', [
            'entreprise' => $entreprise,
            'titre_page' => "Fiche " . $entreprise['nom'] . " | StagePro"
        ]);
    }

    public function create() {
        $this->checkAuth();
        echo $this->twig->render('entreprises/formulaire.html.twig', [
            'titre_page' => "Ajouter une entreprise | StagePro",
            'entreprise' => null // Mode création
        ]);
    }

    public function edit($id) {
        $this->checkAuth();
        $entreprise = $this->model->findById($id);
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
}