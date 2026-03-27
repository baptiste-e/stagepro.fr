<?php
// app/Controllers/PiloteController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class PiloteController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Utilisateur();
        $this->twig = $twig;
    }

    private function requireRoles(array $roles) {
        $userRole = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        if (!isset($_SESSION['user']) || !in_array(strtolower(trim($userRole)), $roles, true)) {
            header('Location: index.php?page=home&error=access_denied');
            exit;
        }
    }

    public function index() {
        $this->requireRoles(['admin', 'pilote']);
        $pilotes = $this->model->findByRole('pilote');
        echo $this->twig->render('pilotes/liste.html.twig', [
            'pilotes' => $pilotes,
            'titre_page' => "Annuaire des pilotes | StagePro"
        ]);
    }

    public function show($id) {
        $this->requireRoles(['admin', 'pilote']);
        $pilote = $this->model->findById($id);
        if (!$pilote) { header('Location: index.php?page=pilotes'); exit; }
        echo $this->twig->render('pilotes/detail.html.twig', [
            'pilote' => $pilote,
            'titre_page' => "Profil Pilote : " . $pilote['nom']
        ]);
    }

    public function create() {
        $this->requireRoles(['admin']);
        echo $this->twig->render('pilotes/formulaire.html.twig', [
            'titre_page' => "Ajouter un pilote | StagePro",
            'modeEdition' => false
        ]);
    }

    public function edit($id) {
        $this->requireRoles(['admin']);
        $pilote = $this->model->findById($id);
        echo $this->twig->render('pilotes/formulaire.html.twig', [
            'pilote' => $pilote,
            'modeEdition' => true,
            'titre_page' => "Modifier le pilote"
        ]);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'nom' => htmlspecialchars($_POST['nom']),
            'prenom' => htmlspecialchars($_POST['prenom']),
            'email' => htmlspecialchars($_POST['email']),
            'role_id' => 2 
        ];
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $id > 0 ? $this->model->update($id, $data) : $this->model->create($data);
        header('Location: index.php?page=pilotes&status=success');
        exit;
    }

    public function delete() {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) { $this->model->delete($id); }
        header('Location: index.php?page=pilotes&message=deleted');
        exit;
    }
}