<?php
// app/Controllers/EtudiantController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class EtudiantController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Utilisateur();
        $this->twig = $twig;
    }

    public function index() {
        $etudiants = $this->model->findByRole('etudiant');
        echo $this->twig->render('etudiants/liste.html.twig', [
            'etudiants' => $etudiants,
            'titre_page' => "Annuaire des étudiants | StagePro"
        ]);
    }

    public function show($id) {
        $etudiant = $this->model->findById($id);
        if (!$etudiant) {
            header('Location: index.php?page=etudiants');
            exit;
        }
        echo $this->twig->render('etudiants/detail.html.twig', [
            'etudiant' => $etudiant,
            'titre_page' => "Profil de " . $etudiant['nom'] . " | StagePro"
        ]);
    }

    public function create() {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }
        echo $this->twig->render('etudiants/formulaire.html.twig', [
            'titre_page' => "Ajouter un étudiant | StagePro",
            'etudiant' => null
        ]);
    }

    public function edit($id) {
        $role = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array($role, ['admin', 'pilote'])) {
            header('Location: index.php?page=home');
            exit;
        }
        $etudiant = $this->model->findById($id);
        echo $this->twig->render('etudiants/formulaire.html.twig', [
            'etudiant' => $etudiant,
            'titre_page' => "Modifier l'étudiant | StagePro"
        ]);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => 3 
        ];
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            $data['mot_de_passe'] = password_hash('Cesi2026!', PASSWORD_DEFAULT);
        }
        $id > 0 ? $this->model->update($id, $data) : $this->model->create($data);
        header('Location: index.php?page=etudiants');
        exit;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) { $this->model->delete($id); }
            header('Location: index.php?page=etudiants&message=deleted');
            exit;
        }
    }
}