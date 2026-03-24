<?php
// app/Controllers/EntrepriseController.php
require_once __DIR__ . '/../Models/Entreprise.php';

class EntrepriseController {
    private $model;

    public function __construct() {
        $this->model = new Entreprise();
    }

    public function index() {
        $entreprises = $this->model->findAll();
        $titre_page = "Annuaire des Entreprises | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id) {
        $entreprise = $this->model->findById($id);
        if (!$entreprise) die("Entreprise introuvable");
        
        $titre_page = "Fiche " . $entreprise['nom'] . " | StagePro";
        
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/entreprises/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}