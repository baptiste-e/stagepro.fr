<?php
// app/Controllers/CandidatureController.php
require_once __DIR__ . '/../Models/Candidature.php';

class CandidatureController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Candidature();
        $this->twig = $twig;
    }

    public function index() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }
        
        $candidatures = $this->model->findByEtudiant($_SESSION['user']['id']);
        echo $this->twig->render('candidatures/liste.html.twig', [
            'candidatures' => $candidatures,
            'titre_page' => "Mes Candidatures | StagePro"
        ]);
    }

    public function show($id) {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }

        $candidature = $this->model->findByIdFull((int)$id);

        if (!$candidature || $candidature['utilisateur_id'] != $_SESSION['user']['id']) {
            header('Location: index.php?page=candidatures');
            exit;
        }

        echo $this->twig->render('candidatures/detail.html.twig', [
            'candidature' => $candidature,
            'titre_page' => "Détail de ma candidature | StagePro"
        ]);
    }
}