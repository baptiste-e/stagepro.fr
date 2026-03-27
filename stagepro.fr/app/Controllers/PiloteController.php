<?php
// app/Controllers/PiloteController.php

require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Role.php';

class PiloteController
{
    private $model;
    private $roleModel;

    public function __construct()
    {
        $this->model = new Utilisateur();
        $this->roleModel = new Role();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    private function requireRoles(array $roles): void
    {
        $userRole = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';

        if (!in_array(strtolower(trim($userRole)), $roles, true)) {
            header('Location: index.php?page=home&error=access_denied');
            exit;
        }
    }

    public function index()
    {
        $this->requireRoles(['admin', 'pilote']);
        $pilotes = $this->model->findByRole('pilote');
        $titre_page = "Annuaire des pilotes | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/liste.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id)
    {
        $this->requireRoles(['admin', 'pilote']);
        $pilote = $this->model->findById((int)$id);

        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $titre_page = "Profil Pilote : " . htmlspecialchars($pilote['nom']);

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/detail.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function create()
    {
        $this->requireRoles(['admin']);
        $titre_page = "Ajouter un pilote | StagePro";
        $modeEdition = false;

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function edit($id)
    {
        $this->requireRoles(['admin']);
        $pilote = $this->model->findById((int)$id);

        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $titre_page = "Modifier le pilote : " . htmlspecialchars($pilote['nom']);
        $modeEdition = true;

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/pilotes/formulaire.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function save()
    {
        $this->requireRoles(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        $rolePilote = $this->roleModel->findByNom('pilote');
        if (!$rolePilote) {
            die("Le rôle 'pilote' est introuvable.");
        }

        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => (int)$rolePilote['id']
        ];

        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            $data['mot_de_passe'] = password_hash('StagePro2026', PASSWORD_DEFAULT);
        }

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=pilotes');
        exit;
    }

    public function delete()
    {
        $this->requireRoles(['admin']);

        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        header('Location: index.php?page=pilotes');
        exit;
    }
}