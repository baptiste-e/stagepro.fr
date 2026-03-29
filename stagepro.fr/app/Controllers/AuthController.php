<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/Utilisateur.php';

class AuthController {
    private $model;
    private $twig;

    /**
     * Le constructeur initialise le modèle et reçoit l'instance Twig
     */
    public function __construct($twig) {
        $this->model = new Utilisateur();
        $this->twig = $twig;
    }

    /**
     * Gère la connexion des utilisateurs
     */
    public function login() {
        $erreur = '';

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['mot_de_passe'] ?? '';

            $user = $this->model->findByEmail($email);

            // Vérification des identifiants et du mot de passe haché
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

        // Rendu de la vue via Twig
        echo $this->twig->render('auth/login.html.twig', [
            'erreur' => $erreur,
            'titre_page' => "Connexion | StagePro"
        ]);
    }

    /**
     * Gère la déconnexion et la destruction de la session
     */
    public function logout() {
        // Réinitialisation du tableau de session
        $_SESSION = [];

        // Destruction physique de la session côté serveur
        if (session_id()) {
            session_destroy();
        }

        // Redirection vers l'accueil après déconnexion
        header('Location: index.php?page=home');
        exit;
    }
}