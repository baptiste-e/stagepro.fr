<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class AuthController {
    private $model;

    public function __construct() {
        $this->model = new Utilisateur();
    }

    public function login() {
        $erreur = '';

        // Si l'utilisateur soumet le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['mot_de_passe'] ?? '';

            $user = $this->model->findByEmail($email);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'role' => $user['role_nom']
                ];
                header('Location: index.php?page=home');
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        }

        $titre_page = "Connexion | StagePro";
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/auth/login.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
}