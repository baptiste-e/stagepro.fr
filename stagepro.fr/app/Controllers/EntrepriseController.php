<?php
// app/Controllers/EntrepriseController.php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;
    private $twig;

    /**
     * Le constructeur reçoit Twig et initialise le modèle
     */
    public function __construct($twig) {
        $this->model = new Entreprise();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté et autorisé (Admin ou Pilote)
     */
    private function checkAuth() {
        $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Affiche l'annuaire des entreprises avec le nombre d'offres par entreprise
     */
    public function index() {
        $entreprises = $this->model->findAll();

        // Fusion de la logique collègues : on ajoute le compte des offres pour chaque entreprise
        foreach ($entreprises as &$entreprise) {
            $entreprise['nb_offres'] = $this->model->countOffresLiees((int)$entreprise['id']);
        }
        unset($entreprise); // Sécurité sur la référence du foreach

        echo $this->twig->render('entreprises/liste.html.twig', [
            'entreprises' => $entreprises,
            'titre_page' => "Annuaire des Entreprises | StagePro"
        ]);
    }

    /**
     * Affiche la fiche détaillée d'une entreprise
     */
    public function show($id) {
        $entreprise = $this->model->findById((int)$id);
        if (!$entreprise) {
            header('Location: index.php?page=entreprises');
            exit;
        }

        // Récupération du nombre d'offres pour cette entreprise précise
        $entreprise['nb_offres'] = $this->model->countOffresLiees((int)$entreprise['id']);
        
        echo $this->twig->render('entreprises/detail.html.twig', [
            'entreprise' => $entreprise,
            'titre_page' => "Fiche " . $entreprise['nom'] . " | StagePro"
        ]);
    }

    /**
     * Affiche le formulaire de création
     */
    public function create() {
        $this->checkAuth();
        echo $this->twig->render('entreprises/formulaire.html.twig', [
            'titre_page' => "Ajouter une entreprise | StagePro",
            'entreprise' => null
        ]);
    }

    /**
     * Affiche le formulaire de modification
     */
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

    /**
     * Sauvegarde une nouvelle entreprise
     */
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

    /**
     * Met à jour une entreprise existante
     */
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

    /**
     * Supprime une entreprise
     */
    public function delete() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->model->delete($id);
            }
            header('Location: index.php?page=entreprises&status=deleted');
            exit;
        }
    }
}