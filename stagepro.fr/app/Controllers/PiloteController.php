<?php
// app/Controllers/PiloteController.php

require_once __DIR__ . '/../Models/Utilisateur.php';
require_once __DIR__ . '/../Models/Role.php';

class PiloteController
{
    private $model;
    private $roleModel;
    private $twig;

    /**
     * Le constructeur initialise les modèles, Twig et vérifie l'authentification
     */
    public function __construct($twig)
    {
        $this->model = new Utilisateur();
        $this->roleModel = new Role();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Sécurité de base : redirige si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Vérification des permissions spécifiques pour restreindre l'accès
     */
    private function requireRoles(array $roles): void
    {
        $userRole = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';

        if (!in_array(strtolower(trim($userRole)), $roles, true)) {
            header('Location: index.php?page=home&error=access_denied');
            exit;
        }
    }

    /**
     * Annuaire des pilotes (Accessible aux Admin & Pilotes)
     */
    public function index()
    {
        $this->requireRoles(['admin', 'pilote']);
        $pilotes = $this->model->findByRole('pilote');
        
        echo $this->twig->render('pilotes/liste.html.twig', [
            'pilotes' => $pilotes,
            'titre_page' => "Annuaire des pilotes | StagePro"
        ]);
    }

    /**
     * Fiche détaillée d'un pilote
     */
    public function show($id)
    {
        $this->requireRoles(['admin', 'pilote']);
        $pilote = $this->model->findById((int)$id);

        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        echo $this->twig->render('pilotes/detail.html.twig', [
            'pilote' => $pilote,
            'titre_page' => "Profil Pilote : " . htmlspecialchars($pilote['nom'])
        ]);
    }

    /**
     * Formulaire de création (Réservé aux Admin)
     */
    public function create()
    {
        $this->requireRoles(['admin']);
        
        echo $this->twig->render('pilotes/formulaire.html.twig', [
            'titre_page' => "Ajouter un pilote | StagePro",
            'modeEdition' => false,
            'pilote' => null
        ]);
    }

    /**
     * Formulaire de modification (Réservé aux Admin)
     */
    public function edit($id)
    {
        $this->requireRoles(['admin']);
        $pilote = $this->model->findById((int)$id);

        if (!$pilote) {
            header('Location: index.php?page=pilotes');
            exit;
        }

        echo $this->twig->render('pilotes/formulaire.html.twig', [
            'pilote' => $pilote,
            'modeEdition' => true,
            'titre_page' => "Modifier le pilote : " . htmlspecialchars($pilote['nom'])
        ]);
    }

    /**
     * Enregistrement en base de données (Create ou Update)
     */
    public function save()
    {
        $this->requireRoles(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=pilotes');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        // Récupération dynamique de l'ID du rôle 'pilote'
        $rolePilote = $this->roleModel->findByNom('pilote');
        if (!$rolePilote) {
            die("Erreur : Le rôle 'pilote' est introuvable en base de données.");
        }

        $data = [
            'nom'     => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom'  => htmlspecialchars($_POST['prenom'] ?? ''),
            'email'   => htmlspecialchars($_POST['email'] ?? ''),
            'role_id' => (int)$rolePilote['id']
        ];

        // Gestion du mot de passe (hachage)
        if (!empty($_POST['password'])) {
            $data['mot_de_passe'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            // Mot de passe temporaire par défaut pour les nouveaux comptes
            $data['mot_de_passe'] = password_hash('StagePro2026', PASSWORD_DEFAULT);
        }

        if ($id > 0) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }

        header('Location: index.php?page=pilotes&status=success');
        exit;
    }

    /**
     * Suppression définitive d'un compte pilote
     */
    public function delete()
    {
        $this->requireRoles(['admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);

            if ($id > 0) {
                $this->model->delete($id);
            }

            header('Location: index.php?page=pilotes&message=deleted');
            exit;
        }
        
        header('Location: index.php?page=pilotes');
        exit;
    }
}