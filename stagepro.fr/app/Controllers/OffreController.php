<?php
// app/Controllers/OffreController.php

require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';

class OffreController {
    private $model;

    public function __construct() {
        $this->model = new Offre();
    }

    /**
     * Liste globale des offres
     */
    public function index() {
        $offres = $this->model->findAll();
        $titre_page = "Offres de stage | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Formulaire Créer/Modifier
     */
    public function create($id = 0) {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if ($role === 'etudiant') {
            die("Accès refusé : les étudiants ne peuvent pas gérer les offres.");
        }

        $modeEdition = ($id > 0);
        $offre = $modeEdition ? $this->model->findById($id) : null;
        
        $entrepriseModel = new Entreprise();
        $entreprises = $entrepriseModel->findAll();

        $titre_page = $modeEdition ? "Modifier une offre | StagePro" : "Publier une offre | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Suppression d'une offre
     */
    public function delete($id) {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || $role === 'etudiant') {
            die("Accès refusé.");
        }

        if ($id > 0) {
            $this->model->delete($id);
        }

        header('Location: index.php?page=offres&message=deleted');
        exit;
    }

    /**
     * Enregistrement (Save)
     */
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=offres');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'titre'         => htmlspecialchars($_POST['titre'] ?? ''),
            'description'   => htmlspecialchars($_POST['description'] ?? ''),
            'competences'   => htmlspecialchars($_POST['competences'] ?? ''),
            'localite'      => htmlspecialchars($_POST['localite'] ?? ''),
            'duree'         => htmlspecialchars($_POST['duree'] ?? ''),
            'remuneration'  => htmlspecialchars($_POST['remuneration'] ?? ''),
            'nb_places'     => (int)($_POST['nb_places'] ?? 1),
            'id_entreprise' => (int)($_POST['id_entreprise'] ?? 0)
        ];

        if ($data['id_entreprise'] <= 0) {
            die("Erreur : Entreprise invalide.");
        }

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=offres');
        exit;
    }

    /**
     * Détail d'une offre
     */
    public function show($id) {
        $offre = $this->model->findById($id);
        if (!$offre) { die("Offre introuvable."); }

        $titre_page = htmlspecialchars($offre['titre']) . " | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    /**
     * Statistiques (La version complète !)
     */
    public function stats() {
        if (!isset($_SESSION['user'])) { 
            header('Location: index.php?page=login'); 
            exit; 
        }

        $statsLocalite = $this->model->getStatsByLocalite();
        $statsEntreprise = $this->model->getStatsByEntreprise();
        $totalOffres = $this->model->countAll();

        $titre_page = "Statistiques des offres | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/offres/stats.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }
}