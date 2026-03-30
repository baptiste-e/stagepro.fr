<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class AuthController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Utilisateur();
        $this->twig = $twig;
    }

    public function login() {
        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? ''; 

            $user = $this->model->findByEmail($email);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'role' => $user['role_nom'] ?? 'etudiant'
                ];
                header('Location: index.php?page=home');
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        }

        echo $this->twig->render('auth/login.html.twig', [
            'erreur' => $erreur,
            'titre_page' => "Connexion | StagePro"
        ]);
    }

    public function logout() {
        $_SESSION = [];
        if (session_id()) {
            session_destroy();
        }
        header('Location: index.php?page=home');
        exit;
    }
}