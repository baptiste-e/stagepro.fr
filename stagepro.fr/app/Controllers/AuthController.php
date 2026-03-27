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

    /**
     * Gère la connexion
     */
    public function login() {
        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['mot_de_passe'] ?? '';

            $user = $this->model->findByEmail($email);

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

        echo $this->twig->render('auth/login.html.twig', [
            'erreur' => $erreur,
            'titre_page' => "Connexion | StagePro"
        ]);
    }

    /**
     * Gère la déconnexion
     */
    public function logout() {
        // On vide toutes les variables de session
        $_SESSION = [];

        // On détruit la session côté serveur
        if (session_id()) {
            session_destroy();
        }

        // Redirection propre vers l'accueil
        header('Location: index.php?page=home');
        exit;
    }
}